<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Exceptions\InvalidSignatureException;
use Koncept\ConsoleApp\Utilities\SignatureParser;
use PHPUnit\Framework\TestCase;


class ZZSignatureParserTest
    extends TestCase
{
    private function assert(string $signature, string $expectedPrimary, ?string $expectedSecondary = null): void
    {
        $sp = new SignatureParser($signature);
        $this->assertTrue($sp->getPrimaryCommand() === $expectedPrimary);
        $this->assertTrue($sp->getSecondaryCommand() === $expectedSecondary);
    }

    private function expect(string $signature): void
    {
        try {
            new SignatureParser($signature);
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