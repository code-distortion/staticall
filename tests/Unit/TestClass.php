<?php

namespace CodeDistortion\Staticall\Tests\Unit;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall, with the normal method prefix.
 *
 * @method static string noParams() A test method that doesn't accept any parameters.
 * @method string noParams() A test method that doesn't accept any parameters.
 * @method static string withParam(string $string1) A test method that accepts 1 parameter.
 * @method string withParam(string $string1) A test method that accepts 1 parameter.
 * @method static string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 * @method string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 */
class TestClass
{
    use Staticall;



    /**
     * A method that accepts no parameters. Returns a string.
     *
     * @return string
     */
    private function callNoParams(): string
    {
        return 'callNoParams';
    }

    /**
     * A method that accepts a string, and returns another based upon it.
     *
     * @param string $string1 The first string.
     * @return string
     */
    private function callWithParam(string $string1): string
    {
        return "callWithParam $string1";
    }

    /**
     * A method that accepts some strings, and returns another based upon them.
     *
     * @param string $string1 The first string.
     * @param string $string2 The second string.
     * @return string
     */
    private function callWithParams(string $string1, string $string2): string
    {
        return "callWithParams $string1 $string2";
    }
}
