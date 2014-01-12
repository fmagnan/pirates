<?php

namespace Ethmael\IO\Input;


class LineParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function recognizeSingleCommand()
    {
        $parser = new LineParser();
        $parser->readLine('quit');
        $this->assertEquals('quit', $parser->getCommand());
        $parser->readLine('qUit');
        $this->assertEquals('quit', $parser->getCommand());
        $parser->readLine(' QuIt');
        $this->assertEquals('quit', $parser->getCommand());
        $parser->readLine('qUIt ');
        $this->assertEquals('quit', $parser->getCommand());
    }

    protected function assertOneArgumentCommand($parser, $expectedCommand, $expectedArgument, $line)
    {
        $parser->readLine($line, 1);
        $this->assertEquals($expectedCommand, $parser->getCommand());
        $arguments = $parser->getArguments();
        $this->assertCount(1, $arguments);
        $this->assertEquals($expectedArgument, $arguments[0]);
    }

    /**
     * @test
     */
    public function recognizeCommandAndArgumentsFromOneArgumentCommand()
    {
        $parser = new LineParser();
        $this->assertOneArgumentCommand($parser, 'rename', 'Jaime', 'rename Jaime');
        $this->assertOneArgumentCommand($parser, 'rename', 'Jaime Lannister', 'rename Jaime Lannister');
        $this->assertOneArgumentCommand($parser, 'rename', 'Jaime Lannister', ' rename Jaime Lannister');
        $this->assertOneArgumentCommand($parser, 'rename', '"Jaime Lannister"', 'rename "Jaime Lannister"  ');
    }

}
