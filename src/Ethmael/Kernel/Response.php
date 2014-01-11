<?php

namespace Ethmael\Kernel;

abstract class Response
{
    protected $lines;

    public function __construct()
    {
        $this->reset();
    }

    public function addLine($line)
    {
        $this->lines[] = $line;
    }

    public function addMultiLines(array $lines)
    {
        foreach ($lines as $line) {
            $this->addLine($line);
        }
    }

    public function reset()
    {
        $this->lines = [];
    }

    abstract public function __toString();
}