<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Exceptions;

use LogicException;
use ReflectionMethod;
use ReflectionParameter;


/**
 * [Exception] Unsupported Parameter Type
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
class UnsupportedParameterTypeException
    extends LogicException
{
    public static function fromReflection(ReflectionMethod $method, ReflectionParameter $param): self
    {
        assert($param->hasType());

        $class = $method->getDeclaringClass();
        return new self(
            "The type of the parameter {$param->getName()} ({$param->getType()->getName()})" .
            "of the method {$method->getShortName()} " .
            "of the class {$class->getShortName()} " .
            "({$class->getName()}) " .
            "declared in {$class->getFileName()} is not supported."
        );
    }
}