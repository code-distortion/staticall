<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that DOESN'T use Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testClass2GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method string testClass2GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class TestClass2 extends TestClass3
{
//    use Staticall; // DOESN'T USE Staticall



    /** @var string The prefix to use when looking for methods to call. */
    protected static $staticallPrefix = 'staticall2';



    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticall2TestClass2GetCallInfo(string $param1 = '', string $param2 = ''): string
    {
        $parts = [
            'testClass2GetCallInfo',
            "($this->value)",
            "(" . implode(', ', func_get_args()). ")",
        ];

        return implode(' ', $parts);
    }
}
