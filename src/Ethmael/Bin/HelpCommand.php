<?php

namespace Ethmael\Bin;

class HelpCommand extends Command
{
    public function __construct()
    {
        parent::__construct('help');
    }

    public function respond()
    {
        return 'TODO --> help';
    }


}