<?php

namespace Ethmael\Bin\Command;

use Ethmael\Bin\Writer;

abstract class AbstractCommand
{
    use Writer;

    protected $alias;

    abstract public function launch($outputStream);

    abstract public function usage();

    public function __construct($alias)
    {
        $this->alias = trim(strtolower($alias));
    }

    public function getAlias()
    {
        return $this->alias;
    }

}