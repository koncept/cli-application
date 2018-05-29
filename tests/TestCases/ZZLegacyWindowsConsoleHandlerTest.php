<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Console\LegacyWindowsConsoleHandler;
use Koncept\ConsoleApp\Tests\Streams\ZZStandardInputForLegacyWindows;
use Koncept\ConsoleApp\Tests\Streams\ZZStandardOutputForLegacyWindows;
use PHPUnit\Framework\TestCase;


class ZZLegacyWindowsConsoleHandlerTest
    extends TestCase
{
    public static function setUpBeforeClass()
    {
        stream_wrapper_register('stdin4lw', ZZStandardInputForLegacyWindows::class);
        stream_wrapper_register('stdout4lw', ZZStandardOutputForLegacyWindows::class);
    }

    public function testPrompt()
    {
        $resource = fopen('stdin4lw://', 'r');
        $ch = new LegacyWindowsConsoleHandler($resource);
        $this->assertEquals('stream', $ch->prompt(false));
    }

    public function testPrint()
    {
        $resource = fopen('stdout4lw://', 'w');
        $ch = new LegacyWindowsConsoleHandler(STDIN, $resource);
        $ch->print("stream\n");
        $this->assertEquals("stream\n", ZZStandardOutputForLegacyWindows::$data);
    }
}