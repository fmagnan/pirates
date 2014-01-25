<?php

namespace Ethmael\Bin;

use Ethmael\Kernel\Request;

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
            $request = new Request($this->readLine());
            if ('quit' === $request) {
                $this->quit();
            }
            try {
                $interpreter->consume($request);
                $response = $interpreter->getResponse();
                $this->out($outputStream, $response);
            } catch (\Exception $e) {
                $this->out($outputStream, $e->getMessage());
            }
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
        $line = trim($line);

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