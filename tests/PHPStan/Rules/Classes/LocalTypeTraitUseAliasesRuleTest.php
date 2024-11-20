<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassForbiddenNameCheck;
use PHPStan\Rules\ClassNameCheck;
use PHPStan\Rules\Generics\GenericObjectTypeCheck;
use PHPStan\Rules\MissingTypehintCheck;
use PHPStan\Rules\PhpDoc\UnresolvableTypeHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LocalTypeTraitUseAliasesRule>
 */
class LocalTypeTraitUseAliasesRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		$reflectionProvider = $this->createReflectionProvider();

		return new LocalTypeTraitUseAliasesRule(
			new LocalTypeAliasesCheck(
				['GlobalTypeAlias' => 'int|string'],
				$this->createReflectionProvider(),
				self::getContainer()->getByType(TypeNodeResolver::class),
				new MissingTypehintCheck(true, []),
				new ClassNameCheck(
					new ClassCaseSensitivityCheck($reflectionProvider, true),
					new ClassForbiddenNameCheck(self::getContainer()),
				),
				new UnresolvableTypeHelper(),
				new GenericObjectTypeCheck(),
				true,
				true,
			),
		);
	}

	public function testRule(): void
	{
		// everything reported by LocalTypeTraitAliasesRule
		$this->analyse([__DIR__ . '/data/local-type-trait-aliases.php'], [
			[
				'Type alias CircularTypeAliasImport2 contains unknown class LocalTypeTraitAliases\CircularTypeAliasImport2.',
				39,
				'Learn more at https://phpstan.org/user-guide/discovering-symbols',
			],
			[
				'Type alias CircularTypeAliasImport1 contains unknown class LocalTypeTraitAliases\CircularTypeAliasImport2.',
				47,
				'Learn more at https://phpstan.org/user-guide/discovering-symbols',
			],
		]);
	}

	public function testRuleSpecific(): void
	{
		$this->analyse([__DIR__ . '/data/local-type-trait-use-aliases.php'], [
			[
				'Type alias A contains unknown class LocalTypeTraitUseAliases\Nonexistent.',
				16,
				'Learn more at https://phpstan.org/user-guide/discovering-symbols',
			],
			[
				'Type alias B contains invalid type LocalTypeTraitUseAliases\SomeTrait.',
				16,
			],
			[
				'Type alias C contains unresolvable type.',
				16,
			],
			[
				'Type alias D contains generic type Exception<int> but class Exception is not generic.',
				16,
			],
		]);
	}

	public function testBug11591(): void
	{
		$this->analyse([__DIR__ . '/data/bug-11591.php'], []);
	}

}
