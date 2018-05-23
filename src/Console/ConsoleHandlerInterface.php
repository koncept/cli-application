<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Console;


/**
 * [Interface] Console Handler
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
interface ConsoleHandlerInterface
{
    /**
     * Prints text.
     *
     * @param string $text
     */
    public function print(string $text): void;

    /**
     * Prompts user for input. If $hidden is true, user's input will be invisible.
     *
     * @param bool $hidden
     * @return string
     */
    public function prompt(bool $hidden = false): string;
}