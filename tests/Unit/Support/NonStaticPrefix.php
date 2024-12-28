<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall - with a non-static $staticallPrefix.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testMethod() A method that returns a string.
 * @method string testMethod() A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class NonStaticPrefix
{
    use Staticall;



    /** @var string The prefix to use when looking for methods to call. */
    protected $staticallPrefix = 'staticallPrefixNonStatic';



    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticallPrefixNonStaticTestMethod(): string
    {
        return 'testMethod';
    }
}
