<?php

namespace Ethmael\Bin;

class Console
{
    protected $inputStream;

    const SIZE_OF_LINE = 1024;
    const PROMPT = '> ';

    public function __construct($inputStream)
    {
        $this->inputStream = $inputStream;
    }

    public function run($outputStream, $interpreter)
    {
        while (true) {
            $this->out($outputStream, self::PROMPT, false);
            $request = $this->readLine();
            if ('quit' === $request) {
                $this->quit();
            }
            $interpreter->consume($request);
            $response = $interpreter->getResponse();
            $this->out($outputStream, $response);
        }
    }

    public function quit()
    {
        fclose($this->inputStream);
        exit;
    }

    protected function readLine()
    {
        $line = fgets($this->inputStream, self::SIZE_OF_LINE);
        $line = trim(strtolower($line));

        return $line;
    }

    public function out($outputStream, $message, $addEndOfLine = true)
    {
        if ($addEndOfLine) {
            $message .= PHP_EOL;
        }
        fwrite($outputStream, $message);
    }

}