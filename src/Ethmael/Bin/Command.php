<?php

namespace Ethmael\Bin;

abstract class Command
{
    protected $alias;

    abstract public function respond();

    public function __construct($alias)
    {
        $this->alias = trim(strtolower($alias));
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function isRunning()
    {
        return true;
    }

    public function launch()
    {
        //do nothing
    }


}