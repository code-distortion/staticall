<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testClass3GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method string testClass3GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method static string sharedMethod() A method that returns a string.
 * @method string sharedMethod() A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class TestClass3 extends TestClass4
{
    use Staticall;



    /** @var string The prefix to use when looking for methods to call. */
    protected static $staticallPrefix = 'staticall3';



    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticall3TestClass3GetCallInfo(string $param1 = '', string $param2 = ''): string
    {
        $parts = [
            'testClass3GetCallInfo',
            "($this->value)",
            "(" . implode(', ', func_get_args()). ")",
        ];

        return implode(' ', $parts);
    }

    /**
     * A method that returns a string, its name means it's shared with its parent / children.
     *
     * @return string
     */
    private function staticall3SharedMethod(): string
    {
        return 'testClass3SharedMethod';
    }
}
