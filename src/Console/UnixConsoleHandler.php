<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Console;

use LogicException;


/**
 * [Class] Console Handler for Unix and Unix-like System
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
class UnixConsoleHandler
    implements ANSIConsoleHandlerInterface
{
    /** @var resource */
    private $in, $out;

    /**
     * UnixConsoleHandler constructor.
     *
     * @param $inputStream
     * @param $outputStream
     */
    public function __construct($inputStream = STDIN, $outputStream = STDOUT)
    {
        if (PHP_SAPI !== 'cli')
            throw new LogicException("UnixConsoleHandler is only available with CLI mode.");

        if (!is_resource($inputStream))
            throw new LogicException("Input stream is not of the type resource.");

        if (!is_resource($outputStream))
            throw new LogicException("Output stream is not of the type resource.");


        $this->in  = $inputStream;
        $this->out = $outputStream;
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
            $ret = exec('read -s PW; echo $PW');
            echo PHP_EOL;
            return $ret;
        } else {
            return rtrim(fgets($this->in), PHP_EOL);
        }
    }

    use ANSIExtensionTrait;
}