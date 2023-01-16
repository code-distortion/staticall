<?php

namespace CodeDistortion\Staticall\Tests\Unit;

use BadMethodCallException;
use CodeDistortion\Staticall\Tests\PHPUnitTestCase;
use CodeDistortion\Staticall\Tests\Unit\Test1\TestClass;
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
    public function test_method_calls()
    {
        $this->assertSame('callNoParams', TestClass::noParams());
        $this->assertSame('callWithParam one', TestClass::withParam('one'));
        $this->assertSame('callWithParams one two', TestClass::withParams('one', 'two'));

        $test = new TestClass();
        $this->assertSame('callNoParams', $test->noParams());
        $this->assertSame('callWithParam one', $test->withParam('one'));
        $this->assertSame('callWithParams one two', $test->withParams('one', 'two'));

        $this->assertSame('callNoParams', TestClass2::noParams());
        $this->assertSame('callWithParam one', TestClass2::withParam('one'));
        $this->assertSame('callWithParams one two', TestClass2::withParams('one', 'two'));

        $test = new TestClass2();
        $this->assertSame('callNoParams', $test->noParams());
        $this->assertSame('callWithParam one', $test->withParam('one'));
        $this->assertSame('callWithParams one two', $test->withParams('one', 'two'));
    }

    /**
     * Test that calls to methods work statically and non-statically.
     *
     * @test
     * @return void
     */
    public function test_with_parents()
    {
        // statically
        $this->assertSame('existingMethodTop-', BottomClass::existingMethodTop());
        $this->assertSame('existingMethodBottom-', BottomClass::existingMethodBottom());



        $this->assertSame('existingMethodTop-', TopClass::existingMethodTop());



        $exceptionWasThrown = false;
        try {
            BottomClass::missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        $this->assertTrue($exceptionWasThrown);



        $exceptionWasThrown = false;
        try {
            TopClass::missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        $this->assertTrue($exceptionWasThrown);



        // non-statically
        $test = new BottomClass();
        $test->setValue('abc');
        $this->assertSame('existingMethodTop-abc', $test->existingMethodTop());
        $this->assertSame('existingMethodBottom-abc', $test->existingMethodBottom());



        $test = new TopClass();
        $test->setValue('abc');
        $this->assertSame('existingMethodTop-abc', $test->existingMethodTop());



        $test = new BottomClass();
        $exceptionWasThrown = false;
        try {
            $test->missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        $this->assertTrue($exceptionWasThrown);



        $test = new TopClass();
        $exceptionWasThrown = false;
        try {
            $test->missingMethod();
        } catch (BadMethodCallException $e) {
            $exceptionWasThrown = true;
        }
        $this->assertTrue($exceptionWasThrown);
    }
}
