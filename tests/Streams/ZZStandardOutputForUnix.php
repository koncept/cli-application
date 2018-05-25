<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\Streams;


class ZZStandardOutputForUnix
{
    public static $buffer = '';

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_write(string $text): int
    {
        return strlen(self::$buffer = $text);
    }
}