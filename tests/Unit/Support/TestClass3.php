<?php

declare(strict_types=1);

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



    /**
     * A method that returns a string.
     *
     * @param string $param1 The first parameter.
     * @param string $param2 The second parameter.
     * @return string
     */
    private function staticallTestClass3GetCallInfo(string $param1 = '', string $param2 = ''): string
    {
        $parts = [
            'testClass3GetCallInfo',
            "($this->value)",
            "(" . implode(', ', func_get_args()) . ")",
        ];

        return implode(' ', $parts);
    }

    /**
     * A method that returns a string, its name means it's shared with its parent / children.
     *
     * @return string
     */
    private function staticallSharedMethod(): string
    {
        return 'testClass3SharedMethod';
    }
}
