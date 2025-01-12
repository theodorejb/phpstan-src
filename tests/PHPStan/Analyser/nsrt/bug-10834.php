<?php

declare(strict_types=1);

namespace Bug10834;

use function PHPStan\Testing\assertType;

/**
 * @return array{1: string, 2: int, 3: bool, 4: string, 5: int, 6: bool, 7: string, 8: int, 9: bool, 10: string, 11: int, 12: bool, 13: string, 14: int, 15: bool, 16: string, 17: int, 18: bool, 19: string, 20: int, 21: bool, 22: string, 23: int, 24: bool, 25: string, 26: int, 27: bool, 28: string, 29: int, 30: bool, 31: string, 32: int, 33: bool, 34: string, 35: int, 36: bool, 37: string, 38: int, 39: bool, 40: string, 41: int, 42: bool, 43: string, 44: int, 45: bool, 46: string, 47: int, 48: bool, 49: string, 50: int, 51: bool, 52: string, 53: int, 54: bool, 55: string, 56: int, 57: bool, 58: string, 59: int, 60: bool, 61: string, 62: int, 63: bool, 64: float}|null
 */
function returnArrayOrNull()
{
	return null;
}

function test(): void {
	$arrayOrNull = returnArrayOrNull();

	assertType('array{1: string, 2: int, 3: bool, 4: string, 5: int, 6: bool, 7: string, 8: int, 9: bool, 10: string, 11: int, 12: bool, 13: string, 14: int, 15: bool, 16: string, 17: int, 18: bool, 19: string, 20: int, 21: bool, 22: string, 23: int, 24: bool, 25: string, 26: int, 27: bool, 28: string, 29: int, 30: bool, 31: string, 32: int, 33: bool, 34: string, 35: int, 36: bool, 37: string, 38: int, 39: bool, 40: string, 41: int, 42: bool, 43: string, 44: int, 45: bool, 46: string, 47: int, 48: bool, 49: string, 50: int, 51: bool, 52: string, 53: int, 54: bool, 55: string, 56: int, 57: bool, 58: string, 59: int, 60: bool, 61: string, 62: int, 63: bool, 64: float}|null', $arrayOrNull);
	assertType('array{}|array{1: string, 2: int, 3: bool, 4: string, 5: int, 6: bool, 7: string, 8: int, 9: bool, 10: string, 11: int, 12: bool, 13: string, 14: int, 15: bool, 16: string, 17: int, 18: bool, 19: string, 20: int, 21: bool, 22: string, 23: int, 24: bool, 25: string, 26: int, 27: bool, 28: string, 29: int, 30: bool, 31: string, 32: int, 33: bool, 34: string, 35: int, 36: bool, 37: string, 38: int, 39: bool, 40: string, 41: int, 42: bool, 43: string, 44: int, 45: bool, 46: string, 47: int, 48: bool, 49: string, 50: int, 51: bool, 52: string, 53: int, 54: bool, 55: string, 56: int, 57: bool, 58: string, 59: int, 60: bool, 61: string, 62: int, 63: bool, 64: float}', $arrayOrNull ?? []);
	assertType('array{}|array{1: string, 2: int, 3: bool, 4: string, 5: int, 6: bool, 7: string, 8: int, 9: bool, 10: string, 11: int, 12: bool, 13: string, 14: int, 15: bool, 16: string, 17: int, 18: bool, 19: string, 20: int, 21: bool, 22: string, 23: int, 24: bool, 25: string, 26: int, 27: bool, 28: string, 29: int, 30: bool, 31: string, 32: int, 33: bool, 34: string, 35: int, 36: bool, 37: string, 38: int, 39: bool, 40: string, 41: int, 42: bool, 43: string, 44: int, 45: bool, 46: string, 47: int, 48: bool, 49: string, 50: int, 51: bool, 52: string, 53: int, 54: bool, 55: string, 56: int, 57: bool, 58: string, 59: int, 60: bool, 61: string, 62: int, 63: bool, 64: float}|null', rand() ? $arrayOrNull : []);
}
