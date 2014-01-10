<?php

namespace Ethmael\Bin;

class Console
{
    use Writer;

    protected $inputStream;
    protected $isRunning;
    protected $interpreter;

    const SIZE_OF_LINE = 1024;
    const PROMPT = '> ';

    public function __construct($inputStream)
    {
        $this->inputStream = $inputStream;
        $this->isRunning = false;
    }

    public function run($outputStream, $disclaimer = '')
    {
        $this->out($outputStream, $disclaimer);
        $this->isRunning = true;
        while ($this->isRunning) {
            $this->out($outputStream, self::PROMPT, false);
            $commandRequested = fgets($this->inputStream, self::SIZE_OF_LINE);
            $this->isRunning = $this->interpreter->executeCommand($outputStream, $commandRequested);
        }
        $this->quit();
    }

    public function quit()
    {
        fclose($this->inputStream);
        exit;
    }

    public function isRunning()
    {
        return $this->isRunning;
    }

    public function useInterpreter(Interpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }
}