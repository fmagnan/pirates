<?php

namespace Ethmael\Bin\Command;

class ExitCommand extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('exit');
    }

    public function launch($outputStream)
    {
        $this->out($outputStream, 'Bye.');
        return false;
    }

    public function usage()
    {
        return 'exit: quit console';
    }

}