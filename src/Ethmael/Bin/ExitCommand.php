<?php

namespace Ethmael\Bin;

class ExitCommand extends Command
{
    public function __construct()
    {
        parent::__construct('exit');
    }

    public function respond()
    {
        return 'Bye.';
    }

    public function isRunning()
    {
        return false;
    }
}