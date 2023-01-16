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
//    /** @var string The prefix to use when looking for methods to call. */
//    protected static $staticallPrefix = 'call';

    /**
     * Allow for "call*" methods to be called NON-STATICALLY.
     *
     * @param string  $method     The method to call.
     * @param mixed[] $parameters The parameters to pass.
     * @return mixed|void
     * @throws BadMethodCallException When the method doesn't exist.
     */
    public function __call(string $method, array $parameters)
    {
        // find out which methods are callable *from this class*
        $methods = [];
        foreach (get_class_methods(self::class) as $tempMethod) {
            $methods[] = strtolower($tempMethod);
        }

        // attempt the call
        $prefix = self::$staticallPrefix ?? 'call';
        if (in_array(strtolower("$prefix$method"), $methods)) {
            $toCall = [$this, "$prefix$method"];
            return is_callable($toCall)
                ? call_user_func_array($toCall, $parameters)
                : null;
        }

        // parent::class will work, even if the direct parent doesn't have one (but one higher up does)
        if (count(class_parents(self::class))) {
            if (method_exists(parent::class, '__call')) {
                return parent::__call($method, $parameters);
            }
        }

        throw new BadMethodCallException("Method \"$method\" does not exist in class " . __CLASS__);
    }

    /**
     * Allow for "call*" methods to be called STATICALLY.
     *
     * @param string  $method     The method to call.
     * @param mixed[] $parameters The parameters to pass.
     * @return mixed|void
     * @throws BadMethodCallException When the method doesn't exist.
     */
    public static function __callStatic(string $method, array $parameters)
    {
        // find out which methods are callable *from this class*
        $methods = [];
        foreach (get_class_methods(self::class) as $tempMethod) {
            $methods[] = strtolower($tempMethod);
        }

        // attempt the call
        $prefix = self::$staticallPrefix ?? 'call';
        if (in_array(strtolower("$prefix$method"), $methods)) {
            $toCall = [new self(), "$prefix$method"];
            return is_callable($toCall)
                ? call_user_func_array($toCall, $parameters)
                : null;
        }

        // loop through each parent until __callStatic is found, or the parents list has been exhausted
        foreach (class_parents(self::class) as $class) {
            if (method_exists($class, '__callStatic')) {
                return parent::__callStatic($method, $parameters);
            }
        }

        throw new BadMethodCallException("Method \"$method\" does not exist in class " . __CLASS__);
    }
}
