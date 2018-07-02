<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Exceptions;

use RuntimeException;


/**
 * [Exception] Malformed Arguments
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 */
class MalformedArgumentsException
    extends RuntimeException
{
    public static function fromCount(): self
    {
        return new self(
            "The number of arguments is wrong."
        );
    }

    public static function fromType(): self
    {
        return new self(
            "The type of an argument is wrong."
        );
    }
}