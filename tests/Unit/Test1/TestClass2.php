<?php

namespace CodeDistortion\Staticall\Tests\Unit\Test1;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall, with a custom method prefix.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string noParams() A test method that doesn't accept any parameters.
 * @method string noParams() A test method that doesn't accept any parameters.
 * @method static string withParam(string $string1) A test method that accepts 1 parameter.
 * @method string withParam(string $string1) A test method that accepts 1 parameter.
 * @method static string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 * @method string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 * @method static string onlyInTestClass2() A test method that only exists in TestClass2.
 * @method string onlyInTestClass2() A test method that only exists in TestClass2.
 *
 * @codingStandardsIgnoreEnd
 */
class TestClass2 extends TestClass1
{
    use Staticall;

    /** @var string The prefix to use when looking for methods to call. */
    protected static $staticallPrefix = 'xyz';



    /**
     * A test method that doesn't accept any parameters.
     *
     * @return string
     */
    private function xyzNoParams(): string
    {
        return 'TestClass2 callNoParams';
    }

    /**
     * A test method that accepts 1 parameter.
     *
     * @param string $string1 The first string.
     * @return string
     */
    private function xyzWithParam(string $string1): string
    {
        return "TestClass2 callWithParam $string1";
    }

    /**
     * A test method that accepts 2 parameters.
     *
     * @param string $string1 The first string.
     * @param string $string2 The second string.
     * @return string
     */
    private function xyzWithParams(string $string1, string $string2): string
    {
        return "TestClass2 callWithParams $string1 $string2";
    }

    /**
     * A test method that only exists in TestClass2.
     *
     * @return string
     */
    private function xyzOnlyInTestClass2(): string
    {
        return "TestClass2 onlyInTestClass2";
    }
}
