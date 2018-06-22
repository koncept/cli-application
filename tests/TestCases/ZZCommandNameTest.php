<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Command\CommandName;
use Koncept\ConsoleApp\Exceptions\InvalidSignatureException;
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
        $cn = new CommandName('primary:secondary');

        $this->assertEquals('primary:secondary', (string)$cn);
        $this->assertEquals('primary:secondary', $cn->getName());
        $this->assertEquals('primary:secondary', $cn->name);
        $this->assertEquals('primary', $cn->getPrimary());
        $this->assertEquals('primary', $cn->primary);
        $this->assertEquals('secondary', $cn->getSecondary());
        $this->assertEquals('secondary', $cn->secondary);
    }


    private function assert(string $signature, string $expectedPrimary, ?string $expectedSecondary = null): void
    {
        $sp = new CommandName($signature);
        $this->assertTrue($sp->getPrimary() === $expectedPrimary);
        $this->assertTrue($sp->getSecondary() === $expectedSecondary);
    }

    private function expect(string $signature): void
    {
        try {
            new CommandName($signature);
            $this->fail();
        } catch (InvalidSignatureException $e) {
            $this->assertTrue(true);
        }
    }

    public function testParse()
    {
        $this->assert('one', 'one');
        $this->assert('one-two', 'one-two');
        $this->assert('one-two-three', 'one-two-three');
        $this->assert('one:two', 'one', 'two');
        $this->assert('one-two:three-four', 'one-two', 'three-four');
        $this->assert('one-two-three:four-five-six', 'one-two-three', 'four-five-six');
    }

    public function testInvalid()
    {
        $this->expect('one-');
        $this->expect('one_two');
        $this->expect('one:two:three');
    }
}