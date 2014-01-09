<?php

namespace Ethmael\Bin;

class Console
{
    protected $inputStream;
    protected $outputStream;
    protected $isRunning;
    protected $commands;

    const SIZE_OF_LINE = 1024;
    const PROMPT = '> ';

    public function __construct($inputStream, $outputStream)
    {
        $this->inputStream = $inputStream;
        $this->outputStream = $outputStream;
        $this->isRunning = false;
        $this->commands=[];
        $this->registerCommand(new HelpCommand());
        $this->registerCommand(new ExitCommand());
    }

    public function out($message, $addEndOfLine = true)
    {
        if ($addEndOfLine) {
            $message .= PHP_EOL;
        }
        fwrite($this->outputStream, $message);
    }

    public function run($disclaimer = '')
    {
        $this->out($disclaimer);

        $this->isRunning = true;

        while ($this->isRunning) {
            $this->out(self::PROMPT, false);
            $request = fgets($this->inputStream, self::SIZE_OF_LINE);
            $this->isRunning = $this->processRequest($request);
        }
    }

    public function registerCommand(Command $command)
    {
        $this->commands[$command->getAlias()] = $command;
    }

    protected function processRequest($request)
    {
        $request = trim(strtolower($request));
        if (!isset($this->commands[$request])) {
            $this->out('invalid command, try "help" to get commands list.');
            return true;
        }
        $command = $this->commands[$request];
        $command->launch();
        $this->out($command->respond());
        return $command->isRunning();
    }

    public function quit()
    {
        unset($this);
    }

    public function __destruct()
    {
        fclose($this->inputStream);
        fclose($this->outputStream);
    }

    public function isRunning()
    {
        return $this->isRunning;
    }
}