<?php

namespace CodeDistortion\Staticall\Tests;

// phpunit added namespacing to its classes in 6.0.0
class_exists(\PHPUnit\Framework\TestCase::class)
    ? class_alias(\PHPUnit\Framework\TestCase::class, TestCase::class)
    : class_alias(\PHPUnit_Framework_TestCase::class, TestCase::class);

//use PHPUnit\Framework\TestCase;

/**
 * The test case that unit tests extend from.
 *
 * @mixin \PHPUnit\Framework\TestCase
 * @mixin \PHPUnit_Framework_TestCase
 */
class PHPUnitTestCase extends TestCase
{
}
