<?php

namespace IncompatibleSelfOutType;

/**
 * @template T
 */
interface A
{
	/** @phpstan-self-out self */
	public function one();

	/**
	 * @template NewT
	 * @param NewT $param
	 * @phpstan-self-out self<NewT>
	 */
	public function two($param);

	/**
	 * @phpstan-self-out int
	 */
	public function three();

	/**
	 * @phpstan-self-out self|null
	 */
	public function four();
}

/**
 * @template T
 */
class Foo
{

	/** @phpstan-self-out self<int> */
	public static function selfOutStatic(): void
	{

	}

	/**
	 * @phpstan-self-out int&string
	 */
	public function doFoo(): void
	{

	}

	/**
	 * @phpstan-self-out self<int&string>
	 */
	public function doBar(): void
	{

	}

}
