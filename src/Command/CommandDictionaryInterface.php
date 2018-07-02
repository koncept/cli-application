<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Command;

use IteratorAggregate;
use Strict\Collection\Vector\Scalar\Vector_string;


/**
 * [Interface] Command Dictionary Interface
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
interface CommandDictionaryInterface
    extends IteratorAggregate
{
    /**
     * Return the name of class referred to $command.
     * Return null if $command is not registered.
     *
     * @param string $command
     * @return null|string
     */
    public function get(string $command): ?string;

    /**
     * Return the name of commands.
     *
     * @return Vector_string
     *
     * @internal
     */
    public function getIterator(): Vector_string;
}