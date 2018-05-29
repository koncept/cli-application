<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Command\CommandFactory;
use Koncept\ConsoleApp\Command\CommandInterface;
use Koncept\ConsoleApp\Tests\Mocks\ZZAbstract;
use Koncept\ConsoleApp\Tests\Mocks\ZZCommand;
use Koncept\ConsoleApp\Tests\Mocks\ZZTrait;
use Koncept\DI\Utility\ObjectContainer;
use PHPUnit\Framework\TestCase;


class ZZCommandFactoryTest
    extends TestCase
{
    public function testSupports()
    {
        $cf = new CommandFactory(new ObjectContainer);

        $this->assertFalse($cf->supports(CommandInterface::class));
        $this->assertFalse($cf->supports(ZZTrait::class));
        $this->assertFalse($cf->supports(ZZAbstract::class));
        $this->assertTrue($cf->supports(ZZCommand::class));
    }
}