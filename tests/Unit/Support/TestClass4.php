<?php

declare(strict_types=1);

namespace CodeDistortion\Staticall\Tests\Unit\Support;

use CodeDistortion\Staticall\Staticall;
use Exception;

/**
 * A test-class that uses Staticall.
 *
 * @codingStandardsIgnoreStart
 *
 * @method static string testClass4GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method string testClass4GetCallInfo(string $param1 = '', string $param2 = '') A method that returns a string.
 * @method static string sharedMethod() A method that returns a string.
 * @method string sharedMethod() A method that returns a string.
 * @method static boolean|null getStaticallMethodCallWasStatic(bool $throwException = false) A method that returns Staticall's $this->staticallMethodCallWasStatic() value.
 * @method boolean|null getStaticallMethodCallWasStatic(bool $throwException = false) A method that returns Staticall's $this->staticallMethodCallWasStatic() value.
 * @method static boolean|null callNestedStaticallMethod(bool $recurseStatically, bool $throwException = false) A method that returns the current $this->staticallMethodCallWasStatic() value, along with the result from a nested call to another Staticall method.
 * @method boolean|null callNestedStaticallMethod(bool $recurseStatically, bool $throwException = false) A method that returns the current $this->staticallMethodCallWasStatic() value, along with the result from a nested call to another Staticall method.
 * @method static void changeValuePassedByReference(int &$value) A method that changes the value passed by reference.
 * @method void changeValuePassedByReference(int &$value) A method that changes the value passed by reference.
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
     * @param string $param1 The first parameter.
     * @param string $param2 The second parameter.
     * @return string
     */
    private function staticallTestClass4GetCallInfo(string $param1 = '', string $param2 = ''): string
    {
        $parts = [
            'testClass4GetCallInfo',
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
        return 'testClass4SharedMethod';
    }





    /**
     * A method that returns Staticall's $this->staticallMethodCallWasStatic() value.
     *
     * @return boolean|null
     */
    public function getStaticallMethodCallWasStaticNow()
    {
        return $this->staticallMethodCallWasStatic();
    }





    /**
     * A method that returns Staticall's $this->staticallMethodCallWasStatic() value.
     *
     * @param boolean $throwException Whether to throw an exception or not.
     * @return boolean|null
     * @throws Exception When $throwException is true.
     */
    private function staticallGetStaticallMethodCallWasStatic(bool $throwException = false)
    {
        if ($throwException) {
            throw new Exception();
        }

        return $this->staticallMethodCallWasStatic();
    }

    /**
     * A method that returns the current $this->staticallMethodCallWasStatic() value, along with the result from a
     * nested call to another Staticall method.
     *
     * @param boolean $recurseStatically Whether to call the next Staticall method statically or not.
     * @param boolean $throwException    Call a second Staticall method that throws an exception instead?.
     *
     * @return array<boolean|null>
     */
    private function staticallCallNestedStaticallMethod(bool $recurseStatically, bool $throwException = false): array
    {
        $a = $this->staticallMethodCallWasStatic(); // record the value that was set in the first place

        try {
            $b = $recurseStatically
                ? static::getStaticallMethodCallWasStatic($throwException)  // call another Staticall method statically
                : $this->getStaticallMethodCallWasStatic($throwException);  // or non-statically (* see below)
            // * NOTE: this will always actually be called non-statically in the end because PHP is actually running
            // THIS method in a non-static context (as Staticall creates an instance of this class, and then calls it
            // non-statically) (see the *Caveat* section in README.md)
        } catch (Exception $e) {
            $b = null;
        }

        $c = $this->staticallMethodCallWasStatic(); // record the value that was returned back again after the nested
                                                    // call

        return [$a, $b, $c];
    }





    /**
     * A method that changes the value passed by reference.
     *
     * @param integer $value The value to change.
     * @return void
     */
    private function staticallChangeValuePassedByReference(int &$value): void
    {
        $value++;
    }
}
