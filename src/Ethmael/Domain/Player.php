<?php

namespace Ethmael\Domain;

class Player
{
    protected $name;

    public function __construct($name)
    {
        $this->rename($name);
    }

    public function rename($name)

    {
        $this->name = $name;
    }

    public function showName()
    {
        return $this->name;
    }
}