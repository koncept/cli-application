<?php declare(strict_types=1);

namespace Koncept\ConsoleApp;


/**
 * [Interface] Console Application Interface
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
interface CLIApplicationInterface
{
    /**
     * Invoke application.
     *
     * @param string ...$argv
     */
    public function __invoke(string ...$argv): void;
}