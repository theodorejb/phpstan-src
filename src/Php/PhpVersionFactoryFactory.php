<?php declare(strict_types = 1);

namespace PHPStan\Php;

use Nette\Utils\Json;
use Nette\Utils\JsonException;
use PHPStan\File\CouldNotReadFileException;
use PHPStan\File\FileReader;
use function count;
use function end;
use function is_array;
use function is_file;
use function is_int;
use function is_string;

final class PhpVersionFactoryFactory
{

	/**
	 * @param int|array{min: int, max: int}|null $phpVersion
	 * @param string[] $composerAutoloaderProjectPaths
	 */
	public function __construct(
		private int|array|null $phpVersion,
		private array $composerAutoloaderProjectPaths,
	)
	{
	}

	public function create(): PhpVersionFactory
	{
		$composerPhpVersion = null;
		if (count($this->composerAutoloaderProjectPaths) > 0) {
			$composerJsonPath = end($this->composerAutoloaderProjectPaths) . '/composer.json';
			if (is_file($composerJsonPath)) {
				try {
					$composerJsonContents = FileReader::read($composerJsonPath);
					$composer = Json::decode($composerJsonContents, Json::FORCE_ARRAY);
					$platformVersion = $composer['config']['platform']['php'] ?? null;
					if (is_string($platformVersion)) {
						$composerPhpVersion = $platformVersion;
					}
				} catch (CouldNotReadFileException | JsonException) {
					// pass
				}
			}
		}

		$versionId = null;

		if (is_int($this->phpVersion)) {
			$versionId = $this->phpVersion;
		}

		if (is_array($this->phpVersion)) {
			$versionId = $this->phpVersion['min'];
		}

		return new PhpVersionFactory($versionId, $composerPhpVersion);
	}

}
