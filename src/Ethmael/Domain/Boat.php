<?php

namespace Ethmael\Domain;

class Boat
{

    protected $level;


    public function __construct()
    {
        $this->level = 1;
    }

    public function getLevel()
    {
        return $this->level;
    }
}