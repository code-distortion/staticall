<?php

namespace CodeDistortion\Staticall\Tests\Unit\Test2;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string existingMethodTop() A test method.
 * @method string existingMethodTop() A test method.
 *
 * @codingStandardsIgnoreEnd
 */
class TopClass
{
    use Staticall;

    /** @var string|null A value to set and check. */
    protected $value = null;



    /**
     * Sets the internal value.
     *
     * @param string $value The value to set.
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * A method that returns a string.
     *
     * @return string
     */
    private function staticallExistingMethodTop(): string
    {
        return "existingMethodTop-$this->value";
    }
}
