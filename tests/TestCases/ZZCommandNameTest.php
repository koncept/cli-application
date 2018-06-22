<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Command\CommandName;
use PHPUnit\Framework\TestCase;


class ZZCommandNameTest
    extends TestCase
{
    public function testPrimaryOnly()
    {
        $cn = new CommandName('primary');

        $this->assertEquals('primary', (string)$cn);
        $this->assertEquals('primary', $cn->getName());
        $this->assertEquals('primary', $cn->name);
        $this->assertEquals('primary', $cn->getPrimary());
        $this->assertEquals('primary', $cn->primary);
        $this->assertNull($cn->getSecondary());
        $this->assertNull($cn->secondary);
    }

    public function testFullname()
    {
        $cn = new CommandName('primary', 'secondary');

        $this->assertEquals('primary:secondary', (string)$cn);
        $this->assertEquals('primary:secondary', $cn->getName());
        $this->assertEquals('primary:secondary', $cn->name);
        $this->assertEquals('primary', $cn->getPrimary());
        $this->assertEquals('primary', $cn->primary);
        $this->assertEquals('secondary', $cn->getSecondary());
        $this->assertEquals('secondary', $cn->secondary);
    }
}