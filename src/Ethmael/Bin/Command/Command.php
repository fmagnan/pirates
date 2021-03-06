<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

abstract class Command
{
    public $alias;
    public $usage;

    public function __construct($alias, $usage)
    {
        $this->alias = $alias;
        $this->usage = $usage;
    }

    abstract public function run(Request $request, Response $response);

}