<?php

namespace Ethmael\Kernel;

class CommandLineResponse extends Response
{
    public function __toString()
    {
        return implode(PHP_EOL, $this->lines);
    }
}