<?php

declare(strict_types=1);

namespace CodeDistortion\Staticall\Tests\Unit;

use CodeDistortion\Staticall\Exceptions\PassByReferenceException;
use CodeDistortion\Staticall\Exceptions\StaticallException;
use CodeDistortion\Staticall\Tests\PHPUnitTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Test the Staticall Exceptions.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class StaticallExceptionsUnitTest extends PHPUnitTestCase
{
    /**
     * Test the exception types.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_the_exception_types()
    {
        self::assertTrue(is_subclass_of(PassByReferenceException::class, StaticallException::class));
    }

    /**
     * Test the exception messages.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_the_exception_messages()
    {
        $class = 'Class1';
        $method = 'method1';
        $param = 'param1';

        $exception = PassByReferenceException::passByReferenceNotSupported($class, $method, $param);

        self::assertSame(
            "Staticall does not support passing variables by reference "
            . "- parameter \$$param in method $class::$method()",
            $exception->getMessage()
        );
    }
}
