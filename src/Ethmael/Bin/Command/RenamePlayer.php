<?php

namespace Ethmael\Bin\Command;

class RenamePlayer extends Command
{
    public function __construct()
    {
        parent::__construct('rename');
    }

    public function launch()
    {
        return 'rename';
    }

    public function usage()
    {
        return 'rename: rename player with new name';
    }

}