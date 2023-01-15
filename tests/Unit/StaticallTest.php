<?php

namespace CodeDistortion\Staticall\Tests\Unit;

use CodeDistortion\Staticall\Tests\PHPUnitTestCase;

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
}
