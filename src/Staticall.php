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
    /** @var string The prefix to use when looking for methods to call. */
#    protected static $staticallPrefix = 'call';

    /**
     * Allow for "call*" methods to be called NOT-STATICALLY.
     *
     * @param string  $method     The method to call.
     * @param mixed[] $parameters The parameters to pass.
     * @return mixed|void
     * @throws BadMethodCallException When the method doesn't exist.
     */
    public function __call(string $method, array $parameters)
    {
        $prefix = static::$staticallPrefix ?? 'call';
        if (method_exists(self::class, "$prefix$method")) {
            $toCall = [$this, "$prefix$method"];
            return is_callable($toCall)
                ? call_user_func_array($toCall, $parameters)
                : null;
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
        $prefix = static::$staticallPrefix ?? 'call';
        if (method_exists(self::class, "$prefix$method")) {
            $toCall = [new self(), "$prefix$method"];
            return is_callable($toCall)
                ? call_user_func_array($toCall, $parameters)
                : null;
        }
        throw new BadMethodCallException("Method \"$method\" does not exist " . __CLASS__);
    }
}
