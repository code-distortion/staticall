<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testClass1GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method string testClass1GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method static string testClass1PublicMethod() A method that returns a string.
 * @method string testClass1PublicMethod() A method that returns a string.
 * @method static string testClass1ProtectedMethod() A method that returns a string.
 * @method string testClass1ProtectedMethod() A method that returns a string.
 * @method static string testClass1PrivateMethod() A method that returns a string.
 * @method string testClass1PrivateMethod() A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class TestClass1 extends TestClass2
{
    use Staticall;



    /** @var string The prefix to use when looking for methods to call. */
    protected static $staticallPrefix = 'staticall1';



    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticall1TestClass1GetCallInfo(string $param1 = '', string $param2 = ''): string
    {
        $parts = [
            'testClass1GetCallInfo',
            "($this->value)",
            "(" . implode(', ', func_get_args()). ")",
        ];

        return implode(' ', $parts);
    }



    /**
     * A public method that returns a string.
     *
     * @return string
     */
    private function staticall1TestClass1PublicMethod(): string
    {
        return 'public';
    }

    /**
     * A protected method that returns a string.
     *
     * @return string
     */
    private function staticall1TestClass1ProtectedMethod(): string
    {
        return 'protected';
    }

    /**
     * A private method that returns a string.
     *
     * @return string
     */
    private function staticall1TestClass1PrivateMethod(): string
    {
        return 'private';
    }
}
