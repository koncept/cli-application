<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\Streams;


class ZZStandardOutputForLegacyWindows
{
    public static $data = '';

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_write(string $data): int
    {
        self::$data = $data;
        return strlen($data);
    }
}