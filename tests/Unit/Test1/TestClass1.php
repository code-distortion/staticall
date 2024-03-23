<?php

namespace CodeDistortion\Staticall\Tests\Unit\Test1;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall, with the normal method prefix.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string noParams() A test method that doesn't accept any parameters.
 * @method string noParams() A test method that doesn't accept any parameters.
 * @method static string withParam(string $string1) A test method that accepts 1 parameter.
 * @method string withParam(string $string1) A test method that accepts 1 parameter.
 * @method static string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 * @method string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 * @method static string onlyInTestClass1() A test method that only exists in TestClass1.
 * @method string onlyInTestClass1() A test method that only exists in TestClass1.
 *
 * @codingStandardsIgnoreEnd
 */
class TestClass1
{
    use Staticall;



    /**
     * A test method that doesn't accept any parameters.
     *
     * @return string
     */
    private function staticallNoParams(): string
    {
        return 'TestClass1 callNoParams';
    }

    /**
     * A test method that accepts 1 parameter.
     *
     * @param string $string1 The first string.
     * @return string
     */
    private function staticallWithParam(string $string1): string
    {
        return "TestClass1 callWithParam $string1";
    }

    /**
     * A test method that accepts 2 parameters.
     *
     * @param string $string1 The first string.
     * @param string $string2 The second string.
     * @return string
     */
    private function staticallWithParams(string $string1, string $string2): string
    {
        return "TestClass1 callWithParams $string1 $string2";
    }

    /**
     * A test method that only exists in TestClass1.
     *
     * @return string
     */
    private function staticallOnlyInTestClass1(): string
    {
        return "TestClass1 onlyInTestClass1";
    }
}
