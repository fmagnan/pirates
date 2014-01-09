<?php

namespace Ethmael\Bin;


class ConsoleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function newConsoleIsNotRunning()
    {
        $console = new Console(fopen('php://memory', 'r'), fopen('php://memory', 'w'));
        $this->assertFalse($console->isRunning());
    }
}