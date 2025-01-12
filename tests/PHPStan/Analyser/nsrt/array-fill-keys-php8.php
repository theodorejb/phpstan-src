<?php // lint >= 8.0

namespace ArrayFillKeysPhp8;

use function PHPStan\Testing\assertType;

function mixedAndSubtractedArray($mixed): void
{
	if (is_array($mixed)) {
		assertType("array<mixed, 'b'>", array_fill_keys($mixed, 'b'));
	} else {
		assertType("*NEVER*", array_fill_keys($mixed, 'b'));
	}
}
