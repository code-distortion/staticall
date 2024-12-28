<?php

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;

/**
 * A test-class that uses Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testClass4GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method string testClass4GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method static string sharedMethod() A method that returns a string.
 * @method string sharedMethod() A method that returns a string.
 *
 * @codingStandardsIgnoreEnd
 */
class TestClass4
{
    use Staticall;



    /** @var string A value to set and check. */
    protected $value = 'unchanged';



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
    private function staticallTestClass4GetCallInfo(string $param1 = '', string $param2 = ''): string
    {
        $parts = [
            'testClass4GetCallInfo',
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
    private function staticallSharedMethod(): string
    {
        return 'testClass4SharedMethod';
    }
}
