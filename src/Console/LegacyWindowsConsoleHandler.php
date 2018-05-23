<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Console;

use LogicException;


/**
 * [Class] Console Handler for Legacy Windows System
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 *
 * @see https://qiita.com/mpyw/items/2e4bf35044a407be536d
 */
class LegacyWindowsConsoleHandler
    implements ConsoleHandlerInterface
{
    private $in, $out;

    /**
     * LegacyWindowsConsoleHandler constructor.
     *
     * @param $in
     * @param $out
     */
    public function __construct($in = STDIN, $out = STDOUT)
    {
        if (!is_resource($in))
            throw new LogicException("Input stream is not of the type resource");

        if (!is_resource($out))
            throw new LogicException("Output stream is not of the type resource");

        if (PHP_SAPI !== 'cli')
            throw new LogicException("LegacyWindowsConsoleHandler is only available with CLI mode.");

        $this->in  = $in;
        $this->out = $out;
    }

    /**
     * Prints text.
     *
     * @param string $text
     */
    public function print(string $text): void
    {
        fputs($this->out, $text);
    }

    /**
     * Prompts user for input. If $hidden is true, user's input will be invisible.
     *
     * @param bool $hidden
     * @return string
     *
     * @see https://qiita.com/mpyw/items/2e4bf35044a407be536d
     */
    public function prompt(bool $hidden = false): string
    {
        if ($hidden) {
            $ret = exec(__DIR__ . '\\prompt.bat');
            echo PHP_EOL;
            return rtrim($ret, PHP_EOL);
        }
        return rtrim(fgets($this->in), PHP_EOL);
    }
}