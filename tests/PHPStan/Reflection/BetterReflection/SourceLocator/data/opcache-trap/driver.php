<?php declare(strict_types = 1);

// Driver for FileReadTrapStreamWrapperTest::testTrapSurvivesOpcacheCacheHit().
// Reproduces the php-standard-library / azjezz/psl layout: a files-autoload
// bootstrap has already loaded the very file the PSR-4 prefix resolves to, so
// the autoloader the trap runs includes it a second time. With OPcache on, the
// include of the already-cached path is served from shared memory and never
// reaches the trap's stream_read() - the real file executes and fatals with
// "Cannot redeclare function OpcacheTrap\thing()".

use PHPStan\Reflection\BetterReflection\SourceLocator\FileReadTrapStreamWrapper;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

$target = __DIR__ . '/function.php';

require_once $target;

spl_autoload_register(static function (string $name) use ($target): void {
	if ($name !== 'OpcacheTrap\thing') {
		return;
	}

	include $target;
});

$opcacheStatus = opcache_get_status(false);
$opcacheEnabled = $opcacheStatus !== false && ($opcacheStatus['opcache_enabled'] ?? false) === true;

// AutoloadSourceLocator::silenceErrors() does the same around the trap.
set_error_handler(static fn (): bool => true);

$locatedFiles = FileReadTrapStreamWrapper::withStreamWrapperOverride(static function (): array {
	$autoloaders = spl_autoload_functions();
	if ($autoloaders === false) {
		return [];
	}

	foreach ($autoloaders as $autoloader) {
		$autoloader('OpcacheTrap\thing');

		if (FileReadTrapStreamWrapper::$autoloadLocatedFiles !== []) {
			return FileReadTrapStreamWrapper::$autoloadLocatedFiles;
		}
	}

	return [];
});

restore_error_handler();

// Compared here rather than in the test so that the separator normalization
// PHP applies to include paths on Windows does not leak into the assertion.
$trappedTarget = array_map('realpath', $locatedFiles) === [realpath($target)];

echo 'opcacheEnabled=', $opcacheEnabled ? '1' : '0', "\n";
echo 'trappedTarget=', $trappedTarget ? '1' : '0', "\n";
