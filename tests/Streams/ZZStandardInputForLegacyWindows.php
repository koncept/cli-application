<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\Streams;


class ZZStandardInputForLegacyWindows
{
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    private $stream = "stream\n";

    public function stream_read(int $count): string
    {
        $ret = substr($this->stream, 0, $count);
        $this->stream = substr($this->stream, $count);
        return $ret;
    }

    public function stream_eof(): bool
    {
        return $this->stream === '';
    }
}