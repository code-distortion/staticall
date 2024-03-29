<?php

namespace CodeDistortion\Staticall\Tests\Unit\Test2;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string existingMethodBottom() A test method.
 * @method string existingMethodBottom() A test method.
 *
 * @codingStandardsIgnoreEnd
 */
class BottomClass extends MiddleClass
{
    use Staticall;

    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticallExistingMethodBottom(): string
    {
        return "existingMethodBottom-$this->value";
    }
}
