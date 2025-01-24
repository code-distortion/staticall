<?php

declare(strict_types=1);

namespace CodeDistortion\Staticall\Exceptions;

/**
 * The exception for when a function is called with a parameter that is passed by reference.
 */
class PassByReferenceException extends StaticallException
{
    /**
     * When a parameter is expected to be passed by reference.
     *
     * @param string $class  The class that the method is in.
     * @param string $method The method that the parameter is in.
     * @param string $param  The parameter that is passed by reference.
     * @return self
     */
    public static function passByReferenceNotSupported(string $class, string $method, string $param): self
    {
        return new self(
            "Staticall does not support passing variables by reference "
            . "- parameter \$$param in method $class::$method()"
        );
    }
}
