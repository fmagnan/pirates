<?php

namespace Ethmael\Domain;

class Player
{
    protected $name;

    public function __construct($name='John Doe')
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