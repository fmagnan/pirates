<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

abstract class Command
{
    public $alias;
    public $usage;
    protected $registry;

    public function __construct(Registry $registry, $alias, $usage)
    {
        $this->registry=$registry;
        $this->alias = $alias;
        $this->usage = $usage;
    }

    abstract public function run(Response $response);

}