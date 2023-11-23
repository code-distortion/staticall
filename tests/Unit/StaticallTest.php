<?php

namespace CodeDistortion\Staticall\Tests\Unit;

use BadMethodCallException;
use CodeDistortion\Staticall\Tests\PHPUnitTestCase;
use CodeDistortion\Staticall\Tests\Unit\Test1\TestClass1;
use CodeDistortion\Staticall\Tests\Unit\Test1\TestClass2;
use CodeDistortion\Staticall\Tests\Unit\Test2\BottomClass;
use CodeDistortion\Staticall\Tests\Unit\Test2\TopClass;

/**
 * Test the Staticall trait.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class StaticallTest extends PHPUnitTestCase
{
    /**
     * Test that calls to methods work statically and non-statically.
     *
     * @test
     * @return void
     */
    public static function test_method_calls()
    {
        self::assertSame('TestClass1 callNoParams', TestClass1::noParams());
        self::assertSame('TestClass1 callWithParam one', TestClass1::withParam('one'));
        self::assertSame('TestClass1 callWithParams one two', TestClass1::withParams('one', 'two'));
        self::assertSame('TestClass1 onlyInTestClass1', TestClass1::onlyInTestClass1());

        $test = new TestClass1();
        self::assertSame('TestClass1 callNoParams', $test->noParams());
        self::assertSame('TestClass1 callWithParam one', $test->withParam('one'));
        self::assertSame('TestClass1 callWithParams one two', $test->withParams('one', 'two'));
        self::assertSame('TestClass1 onlyInTestClass1', $test->onlyInTestClass1());

        self::assertSame('TestClass2 callNoParams', TestClass2::noParams());
        self::assertSame('TestClass2 callWithParam one', TestClass2::withParam('one'));
        self::assertSame('TestClass2 callWithParams one two', TestClass2::withParams('one', 'two'));
        self::assertSame('TestClass1 onlyInTestClass1', TestClass2::onlyInTestClass1());
        self::assertSame('TestClass2 onlyInTestClass2', TestClass2::onlyInTestClass2());

        $test = new TestClass2();
        self::assertSame('TestClass2 callNoParams', $test->noParams());
        self::assertSame('TestClass2 callWithParam one', $test->withParam('one'));
        self::assertSame('TestClass2 callWithParams one two', $test->withParams('one', 'two'));
        self::assertSame('TestClass1 onlyInTestClass1', $test->onlyInTestClass1());
        self::assertSame('TestClass2 onlyInTestClass2', $test->onlyInTestClass2());
    }

    /**
     * Test that calls to methods work statically and non-statically.
     *
     * @test
     * @return void
     */
    public static function test_with_parents()
    {
        // statically
        self::assertSame('existingMethodTop-', BottomClass::existingMethodTop());
        self::assertSame('existingMethodBottom-', BottomClass::existingMethodBottom());



        self::assertSame('existingMethodTop-', TopClass::existingMethodTop());



        $exceptionWasThrown = false;
        try {
            BottomClass::missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        self::assertTrue($exceptionWasThrown);



        $exceptionWasThrown = false;
        try {
            TopClass::missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        self::assertTrue($exceptionWasThrown);



        // non-statically
        $test = new BottomClass();
        $test->setValue('abc');
        self::assertSame('existingMethodTop-abc', $test->existingMethodTop());
        self::assertSame('existingMethodBottom-abc', $test->existingMethodBottom());



        $test = new TopClass();
        $test->setValue('abc');
        self::assertSame('existingMethodTop-abc', $test->existingMethodTop());



        $test = new BottomClass();
        $exceptionWasThrown = false;
        try {
            $test->missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        self::assertTrue($exceptionWasThrown);



        $test = new TopClass();
        $exceptionWasThrown = false;
        try {
            $test->missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        self::assertTrue($exceptionWasThrown);
    }
}
