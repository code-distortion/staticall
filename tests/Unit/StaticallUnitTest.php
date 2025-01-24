<?php

declare(strict_types=1);

namespace CodeDistortion\Staticall\Tests\Unit;

use BadMethodCallException;
use CodeDistortion\Staticall\Exceptions\PassByReferenceException;
use CodeDistortion\Staticall\Tests\PHPUnitTestCase;
use CodeDistortion\Staticall\Tests\Unit\Support\TestClass1;
use CodeDistortion\Staticall\Tests\Unit\Support\TestClass4;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

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
        self::assertSame(
            'testClass1GetCallInfo (unchanged) (one, two)',
            TestClass1::testClass1GetCallInfo('one', 'two')
        );

        // non-static call
        $test = new TestClass1();
        self::assertSame('testClass1GetCallInfo (unchanged) ()', $test->testClass1GetCallInfo());
        self::assertSame('testClass1GetCallInfo (unchanged) (one)', $test->testClass1GetCallInfo('one'));
        self::assertSame('testClass1GetCallInfo (unchanged) (one, two)', $test->testClass1GetCallInfo('one', 'two'));

        // method in a parent class - static call
        self::assertSame('testClass3GetCallInfo (unchanged) ()', TestClass1::testClass3GetCallInfo());
        self::assertSame('testClass3GetCallInfo (unchanged) (one)', TestClass1::testClass3GetCallInfo('one'));
        self::assertSame(
            'testClass3GetCallInfo (unchanged) (one, two)',
            TestClass1::testClass3GetCallInfo('one', 'two')
        );

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
        } catch (BadMethodCallException $e) {
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
        } catch (BadMethodCallException $e) {
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
    public static function test_when_a_new_instance_is_created()
    {
        // static call - instantiates a new instance
        self::assertSame('testClass1GetCallInfo (unchanged) ()', TestClass1::testClass1GetCallInfo());

        // non-static call - doesn't instantiate a new instance (it re-uses the current instance)
        $test = new TestClass1();
        $test->setValue('changed');
        self::assertSame('testClass1GetCallInfo (changed) ()', $test->testClass1GetCallInfo());
    }

    /**
     * Test that Staticall's $this->staticallMethodCallWasStatic() returns the correct value.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_that_staticall_called_statically_flag_is_set()
    {
        // SINGLE Staticall calls

        // static call
        self::assertSame(true, TestClass1::getStaticallMethodCallWasStatic());
        self::assertSame(true, TestClass4::getStaticallMethodCallWasStatic());

        // non-static call
        $test = new TestClass1();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        self::assertSame(false, $test->getStaticallMethodCallWasStatic());   // false while calling
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null
        $test = new TestClass4();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        self::assertSame(false, $test->getStaticallMethodCallWasStatic());   // false while calling
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null



        // SINGLE Staticall calls - with an exception

        // non-static call
        $test = new TestClass1();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        try {
            $test->getStaticallMethodCallWasStatic(true);
        } catch (Throwable $e) {
        }
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null

        $test = new TestClass4();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        try {
            $test->getStaticallMethodCallWasStatic(true);
        } catch (Throwable $e) {
        }
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null



        // NESTED Staticall calls

        // static call
        self::assertSame([true, false, true], TestClass1::callNestedStaticallMethod(true)); // * see below
        self::assertSame([true, false, true], TestClass1::callNestedStaticallMethod(false));
        self::assertSame([true, false, true], TestClass4::callNestedStaticallMethod(true)); // * see below
        self::assertSame([true, false, true], TestClass4::callNestedStaticallMethod(false));

        // non-static call
        $test = new TestClass1();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        self::assertSame([false, false, false], $test->callNestedStaticallMethod(true)); // * see below
        self::assertSame([false, false, false], $test->callNestedStaticallMethod(false));
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null
        $test = new TestClass4();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        self::assertSame([false, false, false], $test->callNestedStaticallMethod(true)); // * see below
        self::assertSame([false, false, false], $test->callNestedStaticallMethod(false));
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null



        // NESTED Staticall calls - with an exception

        // static call
        self::assertSame([true, null, true], TestClass1::callNestedStaticallMethod(true, true)); // * see below
        self::assertSame([true, null, true], TestClass1::callNestedStaticallMethod(false, true));
        self::assertSame([true, null, true], TestClass4::callNestedStaticallMethod(true, true)); // * see below
        self::assertSame([true, null, true], TestClass4::callNestedStaticallMethod(false, true));

        // non-static call
        $test = new TestClass1();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        self::assertSame([false, null, false], $test->callNestedStaticallMethod(true, true)); // * see below
        self::assertSame([false, null, false], $test->callNestedStaticallMethod(false, true));
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null
        $test = new TestClass4();
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // started as null
        self::assertSame([false, null, false], $test->callNestedStaticallMethod(true, true)); // * see below
        self::assertSame([false, null, false], $test->callNestedStaticallMethod(false, true));
        self::assertSame(null, $test->getStaticallMethodCallWasStaticNow()); // returned to null



        // * the second value is not true because the second call is actually made non-statically, because of how
        // Staticall and PHP work (see the *Caveat* section in README.md)
    }

    /**
     * Test that parameters can be passed by reference.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public static function test_pass_by_reference()
    {
        // static call
        $value = 1;
        $caughtException = false;
        try {
            TestClass4::changeValuePassedByReference($value);
        } catch (PassByReferenceException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);
        self::assertSame(1, $value); // i.e. no change

        // non-static call
        $value = 1;
        $test = new TestClass4();
        $caughtException = false;
        try {
            $test->changeValuePassedByReference($value);
        } catch (PassByReferenceException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);
        self::assertSame(1, $value); // i.e. no change
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
            'Method "nonExistentMethod" does not exist in class CodeDistortion\\Staticall\\Tests\\Unit\\Support\\TestClass1',
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
            'Method "nonExistentMethod" does not exist in class CodeDistortion\\Staticall\\Tests\\Unit\\Support\\TestClass1',
            $e->getMessage()
        );
    }
}
