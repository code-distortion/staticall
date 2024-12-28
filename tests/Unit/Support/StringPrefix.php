<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall - with a string $staticallPrefix.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testMethod() A method that returns a string.
 * @method string testMethod() A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class StringPrefix
{
    use Staticall;



    /** @var string The prefix to use when looking for methods to call. */
    protected $staticallPrefix = 'staticallStringPrefix';



    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticallStringPrefixTestMethod(): string
    {
        return 'prefix "staticallStringPrefix"';
    }
}
