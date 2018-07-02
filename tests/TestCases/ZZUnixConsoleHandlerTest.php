<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Console\UnixConsoleHandler;
use Koncept\ConsoleApp\Tests\Streams\ZZStandardInputForUnix;
use Koncept\ConsoleApp\Tests\Streams\ZZStandardOutputForUnix;
use PHPUnit\Framework\TestCase;


class ZZUnixConsoleHandlerTest
    extends TestCase
{
    public static function setUpBeforeClass()
    {
        stream_wrapper_register('stdin4u', ZZStandardInputForUnix::class);
        stream_wrapper_register('stdout4u', ZZStandardOutputForUnix::class);
    }

    public function testBehavior()
    {
        $hand = new UnixConsoleHandler(fopen('stdin4u://', 'r'), fopen('stdout4u://', 'w'));
        $this->assertEquals('stream', $hand->prompt());

        $hand->print('text');
        $this->assertEquals(ZZStandardOutputForUnix::$buffer, 'text');

        $hand->moveCursorUp(3);
        $hand->moveCursorDown(3);
        $hand->moveCursorForward(3);
        $hand->moveCursorBackward(3);

    }
}