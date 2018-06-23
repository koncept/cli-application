<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Exceptions;

use Strict\Collection\Vector\Scalar\Vector_string;
use Throwable;


/**
 * [Interface] ConsoleInputExceptionInterface
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 */
interface ConsoleInputExceptionInterface
    extends Throwable
{
    /**
     * Explain the reason why this exception is thrown.
     *
     * @return Vector_string
     */
    public function explain(): Vector_string;
}