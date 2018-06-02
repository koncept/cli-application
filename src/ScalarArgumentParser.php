<?php declare(strict_types=1);

namespace Koncept\ConsoleApp;

use Closure;
use Koncept\ConsoleApp\Exceptions\MalformedArgumentsException;
use Koncept\ConsoleApp\Exceptions\UnsupportedParameterTypeException;
use ReflectionMethod;


/**
 * [Class] Scalar Argument Parser
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 *
 * @internal
 */
class ScalarArgumentParser
{
    private const TYPE_STRING = 0;
    private const TYPE_INT    = 1;
    private const TYPE_FLOAT  = 2;
    private const TYPE_BOOL   = 3;

    /** @var Closure */
    private $typeGenerator;

    /** @var int */
    private $minArgCount, $maxArgCount;

    /**
     * ScalarArgumentParser constructor.
     *
     * @param ReflectionMethod $method
     */
    public function __construct(ReflectionMethod $method)
    {
        $parameters = $method->getParameters();
        $min        = 0;
        $max        = 0;

        $types = [];

        $variadic = false;

        foreach ($parameters as $parameter) {
            if ($parameter->hasType()) {

                $type = $parameter->getType();
                if (!$type->isBuiltin())
                    throw UnsupportedParameterTypeException::fromReflection($method, $parameter);

                switch ($type->getName()) {
                    case 'int':
                        $types[] = self::TYPE_INT;
                        break;
                    case 'float':
                        $types[] = self::TYPE_FLOAT;
                        break;
                    case 'string':
                        $types[] = self::TYPE_STRING;
                        break;
                    case 'bool':
                        $types[] = self::TYPE_BOOL;
                        break;
                    default:
                        throw UnsupportedParameterTypeException::fromReflection($method, $parameter);
                }

            } else {
                $types[] = self::TYPE_STRING;
            }

            if ($parameter->isVariadic()) {
                $variadic = true;
                $max      = -1;
                break;
            }

            $max++;
            if (!$parameter->isOptional()) $min = $max;
        }

        $this->minArgCount = $min;
        $this->maxArgCount = $max;

        if ($variadic) {
            $this->typeGenerator = function () use ($types) {
                assert(count($types) >= 1);
                $lastType = self::TYPE_STRING;

                foreach ($types as $type) {
                    $lastType = $type;
                    yield $type;
                }

                while (1) yield $lastType;
            };
        } else {
            $this->typeGenerator = function () use ($types): array {
                return $types;
            };
        }

    }

    /**
     * Format arguments.
     *
     * @param string ...$arguments
     * @return array
     */
    public function format(string ...$arguments): array
    {
        $c = count($arguments);
        if ($c < $this->minArgCount || ($this->maxArgCount >= 0 && $this->maxArgCount < $c)) {
            throw MalformedArgumentsException::fromCount();
        }

        $retArg = [];
        foreach (($this->typeGenerator)() as $id => $type) {
            if (!isset($arguments[$id])) break;

            $arg = $arguments[$id];
            switch ($type) {
                case self::TYPE_INT:
                    $r = filter_var($arg, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_HEX | FILTER_FLAG_ALLOW_OCTAL);
                    if ($r === false) {
                        throw MalformedArgumentsException::fromType();
                    }
                    $retArg[] = (int)$r;
                    break;
                case self::TYPE_FLOAT:
                    $r = filter_var($arg, FILTER_VALIDATE_FLOAT);
                    if ($r === false) {
                        throw MalformedArgumentsException::fromType();
                    }
                    $retArg[] = (float)$r;
                    break;
                case self::TYPE_BOOL:
                    $r = filter_var($arg, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    if (is_null($r)) {
                        throw MalformedArgumentsException::fromType();
                    }
                    $retArg[] = (bool)$r;
                    break;
                default:
                    $retArg[] = (string)$arg;
                    break;
            }
        }

        return $retArg;
    }
}