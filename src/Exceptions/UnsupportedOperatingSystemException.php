<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Exceptions;

use RuntimeException;


/**
 * [Exception] Unsupported OS
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
class UnsupportedOperatingSystemException
    extends RuntimeException
{
    public static function FromUName(): self
    {
        $os = php_uname();
        return new self(
            "The operating system {$os} is not supported."
        );
    }
}