<?php

namespace CodeDistortion\Staticall\Tests\Unit;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall, with a custom method prefix.
 *
 * @method static string noParams() A test method that doesn't accept any parameters.
 * @method string noParams() A test method that doesn't accept any parameters.
 * @method static string withParam(string $string1) A test method that accepts 1 parameter.
 * @method string withParam(string $string1) A test method that accepts 1 parameter.
 * @method static string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 * @method string withParams(string $string1, string $string2) A test method that accepts 2 parameters.
 */
class TestClass2
{
    use Staticall;

    /** @var string The prefix to use when looking for methods to call. */
    protected static $staticallPrefix = 'xyz';



    /**
     * A method that accepts no parameters. Returns a string.
     *
     * @return string
     */
    private function xyzNoParams(): string
    {
        return 'callNoParams';
    }

    /**
     * A method that accepts a string, and returns another based upon it.
     *
     * @param string $string1 The first string.
     * @return string
     */
    private function xyzWithParam(string $string1): string
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
    private function xyzWithParams(string $string1, string $string2): string
    {
        return "callWithParams $string1 $string2";
    }
}
