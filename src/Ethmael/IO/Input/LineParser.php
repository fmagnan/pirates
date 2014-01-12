<?php

namespace Ethmael\IO\Input;

class LineParser
{

    protected $command;
    protected $args;

    public function readLine($line, $argsCount = 0)
    {
        $line = trim($line);
        $tokens = explode(' ', $line);
        $command = strtolower(array_shift($tokens));
        $this->command = $command;
        if ($argsCount===0) {
            return;
        }
        if ($argsCount == 1) {
            $this->args = [implode(' ', $tokens)];
        }
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getArguments()
    {
        return $this->args;
    }

}