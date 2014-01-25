<?php

namespace Ethmael\Kernel;

class Request
{
    protected $command;
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
        $this->extractCommand();
    }

    protected function extractCommand()
    {
        $parts = explode(' ', $this->content);
        $this->command = array_shift($parts);
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function __toString()
    {
        return $this->content;
    }
}