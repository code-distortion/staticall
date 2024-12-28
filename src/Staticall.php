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
//    protected static string $staticallPrefix = 'staticall';

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
        // resolve the method prefix
        $prefix = get_class_vars(self::class)['staticallPrefix'] ?? 'staticall';
        if (!is_string($prefix)) {
            $prefix = 'staticall';
        }

        // find the methods that exist *in THIS class*
        $methods = array_map('strtolower', get_class_methods(self::class));

        // attempt the call
        if (in_array(strtolower("$prefix$method"), $methods, true)) {
            $callable = [$this, "$prefix$method"];
            if (is_callable($callable)) {
                return call_user_func_array($callable, $parameters);
            }
        }

        // parent::class will work, even if the direct parent doesn't have one (but one higher up does)
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
        // resolve the method prefix
        $prefix = get_class_vars(self::class)['staticallPrefix'] ?? 'staticall';
        if (!is_string($prefix)) {
            $prefix = 'staticall';
        }

        // find the methods that exist *in THIS class*
        $methods = array_map('strtolower', get_class_methods(self::class));

        // attempt the call
        if (in_array(strtolower("$prefix$method"), $methods, true)) {
            $callable = [new self(), "$prefix$method"];
            if (is_callable($callable)) {
                return call_user_func_array($callable, $parameters);
            }
        }

        // loop through each PARENT until __callStatic is found, or the parents list has been exhausted
        foreach (class_parents(self::class) as $class) {
            if (method_exists($class, '__callStatic')) {
                return parent::__callStatic($method, $parameters);
            }
        }

        throw new BadMethodCallException("Method \"$method\" does not exist in class " . static::class);
    }
}
