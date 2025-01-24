<?php

namespace CodeDistortion\Staticall;

use BadMethodCallException;

/**
 * Trait to allow class methods to be called statically or non-statically.
 *
 * Adds the __call(..) and __callStatic(..) methods.
 */
trait Staticall
{
    /** @var boolean|null A flag to indicate that the current "staticall*" method was called statically. */
    private $staticallMethodCallWasStatic = null;



    /**
     * Allow for "staticall*" methods to be called NON-STATICALLY.
     *
     * @param string  $method     The method to call.
     * @param mixed[] $parameters The parameters to pass.
     * @return mixed|void
     * @throws BadMethodCallException When the method doesn't exist.
     */
    public function __call(string $method, array $parameters)
    {
        // find the methods that exist *in THIS class*
        $methods = array_map('strtolower', get_class_methods(self::class));

        // attempt the call
        if (in_array(strtolower("staticall$method"), $methods, true)) {
            $callable = [$this, "staticall$method"];
            if (is_callable($callable)) {

                // set the flag to indicate that this method was called statically
                $prev = $this->staticallMethodCallWasStatic;
                $this->staticallMethodCallWasStatic = false;

                try {
                    $return = call_user_func_array($callable, $parameters);
                } finally {
                    // replace the flag back again
                    $this->staticallMethodCallWasStatic = $prev;
                }

                return $return;
            }
        }

        // call the parent's __call() method
        // parent::class will work, even if the direct parent doesn't have one (but a higher up one does)
        if (count(class_parents(self::class)) !== 0) {
            if (method_exists(parent::class, '__call')) {
                return parent::__call($method, $parameters);
            }
        }

        throw new BadMethodCallException("Method \"$method\" does not exist in class " . static::class);
    }

    /**
     * Allow for "staticall*" methods to be called STATICALLY.
     *
     * @param string  $method     The method to call.
     * @param mixed[] $parameters The parameters to pass.
     * @return mixed|void
     * @throws BadMethodCallException When the method doesn't exist.
     */
    public static function __callStatic(string $method, array $parameters)
    {
        // find the methods that exist *in THIS class*
        $methods = array_map('strtolower', get_class_methods(self::class));

        // attempt the call
        if (in_array(strtolower("staticall$method"), $methods, true)) {
            $new = new self();
            $callable = [$new, "staticall$method"];
            if (is_callable($callable)) {

                // set the flag to indicate that this method was called statically
                $new->staticallMethodCallWasStatic = true;

                return call_user_func_array($callable, $parameters);
            }
        }

        // loop through each PARENT until __callStatic() is found, or the parent list has been exhausted
        foreach (class_parents(self::class) as $class) {
            if (method_exists($class, '__callStatic')) {
                return parent::__callStatic($method, $parameters);
            }
        }

        throw new BadMethodCallException("Method \"$method\" does not exist in class " . static::class);
    }



    /**
     * Check to see if the current "staticall*" method was called statically.
     *
     * @return boolean|null
     */
    private function staticallMethodCallWasStatic()
    {
        return $this->staticallMethodCallWasStatic;
    }
}
