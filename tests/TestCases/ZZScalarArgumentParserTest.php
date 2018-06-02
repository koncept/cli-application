<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Tests\TestCases;

use Koncept\ConsoleApp\Exceptions\MalformedArgumentsException;
use Koncept\ConsoleApp\Exceptions\UnsupportedParameterTypeException;
use Koncept\ConsoleApp\ScalarArgumentParser;
use PHPUnit\Framework\TestCase;
use ReflectionObject;


class ZZScalarArgumentParserTest
    extends TestCase
{
    public function refVariadicMethod(int $n, bool ...$m) { }

    public function refOptionalMethod(int $n = 3) { }

    public function refNoArgMethod() { }

    public function refNoTypeMethod($v) { }

    public function refClassMethod(self $v) { }

    public function refBuiltinMethod(iterable $v) { }


    /** @var ReflectionObject */
    private $reflection;

    public function setUp()
    {
        $this->reflection = new ReflectionObject($this);
    }

    public function testUnsupportedParameterTypeClass()
    {
        $this->expectException(UnsupportedParameterTypeException::class);
        new ScalarArgumentParser($this->reflection->getMethod('refClassMethod'));
    }

    public function testUnsupportedParameterTypeScalar()
    {
        $this->expectException(UnsupportedParameterTypeException::class);
        new ScalarArgumentParser($this->reflection->getMethod('refBuiltinMethod'));
    }

    public function testNoArg()
    {
        $method = $this->reflection->getMethod('refNoArgMethod');
        $parser = new ScalarArgumentParser($method);

        $this->assertEquals([], $parser->format());

        $this->expectException(MalformedArgumentsException::class);
        $parser->format('');
    }

    public function testOptional()
    {
        $method = $this->reflection->getMethod('refOptionalMethod');
        $parser = new ScalarArgumentParser($method);

        $this->assertEquals([], $parser->format());
        $this->assertEquals([3], $parser->format(' 3 '));

        $this->expectException(MalformedArgumentsException::class);
        $parser->format('3.3');
    }

    public function testOptional2()
    {
        $method = $this->reflection->getMethod('refOptionalMethod');
        $parser = new ScalarArgumentParser($method);

        $this->expectException(MalformedArgumentsException::class);
        $parser->format('3', '3');
    }

    public function testNoTypeMethod()
    {
        $method = $this->reflection->getMethod('refNoTypeMethod');
        $parser = new ScalarArgumentParser($method);

        $parser->format('aa');
        $this->expectException(MalformedArgumentsException::class);
        $parser->format();
    }

    public function testVariadic()
    {
        $method = $this->reflection->getMethod('refVariadicMethod');
        $parser = new ScalarArgumentParser($method);

        $this->assertEquals([3], $parser->format('3'));
        $this->assertEquals([3, true], $parser->format('3', 'TruE'));
        $this->assertEquals([3, true, false], $parser->format('3', 'YeS', 'False'));
    }
}