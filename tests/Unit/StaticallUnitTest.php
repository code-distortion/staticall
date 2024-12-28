<?php

namespace CodeDistortion\Staticall\Tests\Unit;

use BadMethodCallException;
use CodeDistortion\Staticall\Tests\PHPUnitTestCase;
use CodeDistortion\Staticall\Tests\Unit\Support\IntegerPrefix;
use CodeDistortion\Staticall\Tests\Unit\Support\StaticPrefix;
use CodeDistortion\Staticall\Tests\Unit\Support\NonStaticPrefix;
use CodeDistortion\Staticall\Tests\Unit\Support\StringPrefix;
use CodeDistortion\Staticall\Tests\Unit\Support\TestClass1;
use PHPUnit\Framework\Attributes\Test;

/**
 * Test the Staticall trait.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class StaticallUnitTest extends PHPUnitTestCase
{
    /**
     * Test that method names are case-insensitive.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_method_names_are_case_insensitive()
    {
        // static call
        self::assertSame('testClass1GetCallInfo (unchanged) ()', TestClass1::TESTCLASS1GETCALLINFO());

        // non-static call
        $test = new TestClass1();
        self::assertSame('testClass1GetCallInfo (unchanged) ()', $test->TESTCLASS1GETCALLINFO());
    }

    /**
     * Test that parameters are passed to Staticall methods properly
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_parameters_are_passed()
    {
        // static call
        self::assertSame('testClass1GetCallInfo (unchanged) ()', TestClass1::testClass1GetCallInfo());
        self::assertSame('testClass1GetCallInfo (unchanged) (one)', TestClass1::testClass1GetCallInfo('one'));
        self::assertSame('testClass1GetCallInfo (unchanged) (one, two)', TestClass1::testClass1GetCallInfo('one', 'two'));

        // non-static call
        $test = new TestClass1();
        self::assertSame('testClass1GetCallInfo (unchanged) ()', $test->testClass1GetCallInfo());
        self::assertSame('testClass1GetCallInfo (unchanged) (one)', $test->testClass1GetCallInfo('one'));
        self::assertSame('testClass1GetCallInfo (unchanged) (one, two)', $test->testClass1GetCallInfo('one', 'two'));

        // method in a parent class - static call
        self::assertSame('testClass3GetCallInfo (unchanged) ()', TestClass1::testClass3GetCallInfo());
        self::assertSame('testClass3GetCallInfo (unchanged) (one)', TestClass1::testClass3GetCallInfo('one'));
        self::assertSame('testClass3GetCallInfo (unchanged) (one, two)', TestClass1::testClass3GetCallInfo('one', 'two'));

        // method in a parent class - non-static call
        $test = new TestClass1();
        self::assertSame('testClass3GetCallInfo (unchanged) ()', $test->testClass3GetCallInfo());
        self::assertSame('testClass3GetCallInfo (unchanged) (one)', $test->testClass3GetCallInfo('one'));
        self::assertSame('testClass3GetCallInfo (unchanged) (one, two)', $test->testClass3GetCallInfo('one', 'two'));
    }

    /**
     * Test that parent class methods can be called, even when a parent in the hierarchy doesn't use the Staticall
     * trait.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_parent_class_methods_can_be_called()
    {
        // static call
        self::assertSame('testClass1GetCallInfo (unchanged) ()', TestClass1::testClass1GetCallInfo());

        // TestClass2 doesn't use the Staticall trait
        $e = null;
        try {
            TestClass1::testClass2GetCallInfo();
        } catch(BadMethodCallException $e) {
        }
        self::assertInstanceOf(BadMethodCallException::class, $e);

        self::assertSame('testClass3GetCallInfo (unchanged) ()', TestClass1::testClass3GetCallInfo());
        self::assertSame('testClass4GetCallInfo (unchanged) ()', TestClass1::testClass4GetCallInfo());



        // non-static call
        $test = new TestClass1();
        self::assertSame('testClass1GetCallInfo (unchanged) ()', $test->testClass1GetCallInfo());

        // TestClass2 doesn't use the Staticall trait
        $e = null;
        try {
            $test->testClass2GetCallInfo();
        } catch(BadMethodCallException $e) {
        }
        self::assertInstanceOf(BadMethodCallException::class, $e);

        self::assertSame('testClass3GetCallInfo (unchanged) ()', $test->testClass3GetCallInfo());
        self::assertSame('testClass4GetCallInfo (unchanged) ()', $test->testClass4GetCallInfo());
    }

    /**
     * Test that the method to be called can be public, protected or private.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_the_visibility_of_called_methods()
    {
        // static call
        self::assertSame('public', TestClass1::testClass1PublicMethod());
        self::assertSame('protected', TestClass1::testClass1ProtectedMethod());
        self::assertSame('private', TestClass1::testClass1PrivateMethod());

        // non-static call
        $test = new TestClass1();
        self::assertSame('public', $test->testClass1PublicMethod());
        self::assertSame('protected', $test->testClass1ProtectedMethod());
        self::assertSame('private', $test->testClass1PrivateMethod());
    }

    /**
     * Test that the parents are tried in order.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_the_parents_are_tried_in_order()
    {
        // testClass3's staticall3SharedMethod() should be called,  and not TestClass4's staticallSharedMethod()

        // static call
        self::assertSame('testClass3SharedMethod', TestClass1::sharedMethod());

        // non-static call
        $test = new TestClass1();
        self::assertSame('testClass3SharedMethod', $test->sharedMethod());
    }

    /**
     * Test that a new class instance is instantiated when calling a static method, and the current instance is reused
     * when calling a non-static method.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_hen_a_new_instance_is_created()
    {
        // static call - instantiates a new instance
        self::assertSame('testClass1GetCallInfo (unchanged) ()', TestClass1::testClass1GetCallInfo());

        // non-static call - doesn't instantiate a new instance (it re-uses the current instance)
        $test = new TestClass1();
        $test->setValue('changed');
        self::assertSame('testClass1GetCallInfo (changed) ()', $test->testClass1GetCallInfo());
    }

    /**
     * Test that the default $staticallPrefix is 'staticall'.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_the_default_staticall_method_name_prefix()
    {
        // static call - instantiates a new instance
        // "staticall" (default)
        self::assertSame('testClass4GetCallInfo (unchanged) ()', TestClass1::testClass4GetCallInfo());

        // non-static call - doesn't instantiate a new instance (it re-uses the current instance)
        $test = new TestClass1();
        // "staticall" (default)
        self::assertSame('testClass4GetCallInfo (unchanged) ()', $test->testClass4GetCallInfo());
    }

    /**
     * Test that the $staticallPrefix is relative to the class it's used in.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_the_staticall_method_prefix_is_relative_to_the_class()
    {
        // static call
        // "staticall1"
        self::assertSame('testClass1GetCallInfo (unchanged) ()', TestClass1::testClass1GetCallInfo());
        // "staticall3"
        self::assertSame('testClass3GetCallInfo (unchanged) ()', TestClass1::testClass3GetCallInfo());
        // "staticall" (default)
        self::assertSame('testClass4GetCallInfo (unchanged) ()', TestClass1::testClass4GetCallInfo());

        // non-static call
        $test = new TestClass1();
        // "staticall1"
        self::assertSame('testClass1GetCallInfo (unchanged) ()', $test->testClass1GetCallInfo());
        // "staticall3"
        self::assertSame('testClass3GetCallInfo (unchanged) ()', $test->testClass3GetCallInfo());
        // "staticall" (default)
        self::assertSame('testClass4GetCallInfo (unchanged) ()', $test->testClass4GetCallInfo());
    }

    /**
     * Test that the $staticallPrefix can be either static or non-static.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_the_staticall_method_prefix_can_be_static_or_non_static()
    {
        // static call
        self::assertSame('testMethod', StaticPrefix::testMethod());
        self::assertSame('testMethod', NonStaticPrefix::testMethod());

        // non-static call
        $test = new StaticPrefix();
        self::assertSame('testMethod', $test->testMethod());
        $test = new NonStaticPrefix();
        self::assertSame('testMethod', $test->testMethod());
    }

    /**
     * Test that non-string $staticallPrefix values are ignored.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_the_staticall_method_prefix_must_be_a_string()
    {
        // static call
        self::assertSame('prefix "staticallStringPrefix"', StringPrefix::testMethod());
        self::assertSame('prefix "staticall"', IntegerPrefix::testMethod()); // the prefix is ignored

        // non-static call
        $test = new StringPrefix();
        self::assertSame('prefix "staticallStringPrefix"', $test->testMethod());
        $test = new IntegerPrefix();
        self::assertSame('prefix "staticall"', $test->testMethod()); // the prefix is ignored
    }

    /**
     * Test that exceptions are thrown properly.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_exceptions_are_thrown_properly()
    {
        // static call
        $e = null;
        try {
            TestClass1::nonExistentMethod();
        } catch (BadMethodCallException $e) {
        }
        self::assertInstanceOf(BadMethodCallException::class, $e);
        self::assertSame(
            'Method "nonExistentMethod" does not exist in class CodeDistortion\Staticall\Tests\Unit\Support\TestClass1',
            $e->getMessage()
        );

        // non-static call
        $e = null;
        try {
            $test = new TestClass1();
            $test->nonExistentMethod();
        } catch (BadMethodCallException $e) {
        }
        self::assertInstanceOf(BadMethodCallException::class, $e);
        self::assertSame(
            'Method "nonExistentMethod" does not exist in class CodeDistortion\Staticall\Tests\Unit\Support\TestClass1',
            $e->getMessage()
        );
    }
}
