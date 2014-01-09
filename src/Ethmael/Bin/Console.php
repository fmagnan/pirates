<?php

namespace Ethmael\Bin;

class Console
{
    protected $inputStream;
    protected $outputStream;
    protected $isRunning;

    const SIZE_OF_LINE = 1024;

    public function __construct($inputStream, $outputStream)
    {
        $this->inputStream = $inputStream;
        $this->outputStream = $outputStream;
        $this->isRunning = false;
    }

    public function out($message, $addEndOfLine = true)
    {
        if ($addEndOfLine) {
            $message .= PHP_EOL;
        }
        fwrite($this->outputStream, $message);
    }

    public function run()
    {
        $this->out('Welcome in Pirates! Game Of The Year Edition.');
        $this->out('To select an option, type the choice between bracket [].');

        $this->isRunning = true;

        while ($this->isRunning) {
            $this->out('Hello ');
            $this->out('[1] - I want to rename myself!');
            $this->out('[2] - Let\'s go to Rumble.');
            $this->out('[3] - Exit.');
            $this->out('> ', false);
            $request = fgets($this->inputStream, self::SIZE_OF_LINE);
            $this->isRunning = $this->processRequest($request);
        }
    }

    protected function processRequest($request)
    {
        $continueLoop = true;
        switch ($request) {
            case '1' . PHP_EOL:
                $this->changePlayerName();
                break;
            case '2' . PHP_EOL:
                $this->launchGame();
                break;
            case '3' . PHP_EOL:
                $this->out('Bye.');
                $continueLoop = false;
                break;
            default:
                $this->out('Invalid choice, same player shoot again');
                break;
        }
        return $continueLoop;
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