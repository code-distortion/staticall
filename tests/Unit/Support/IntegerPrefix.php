<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall - with an integer $staticallPrefix.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testMethod() A method that returns a string.
 * @method string testMethod() A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class IntegerPrefix
{
    use Staticall;



    /** @var integer The prefix to use when looking for methods to call. */
    protected $staticallPrefix = 1234;



    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticallTestMethod(): string
    {
        return 'prefix "staticall"';
    }
}
