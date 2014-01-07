<?php

namespace Ethmael\Domain;

class City
{
    protected $cityName;
    protected $traders;


    public function __construct($name="defaultName")
    {
        $this->traders = [];
        $this->cityName = $name;
    }

    public function newName($name)
    {
        $this->cityName = $name;
    }

    public function getAvailableTraders()
    {
        return $this->traders;
    }

    public function addTrader(Trader $trader)
    {
        $this->traders[] = $trader;
    }

    public function canDealWith(Trader $trader)
    {
        foreach ($this->traders as $item) {
            if ($trader->getType() === $item->getType()) {
                return true;
            }
        }
        return false;
    }

    public function name()
    {
        return $this->cityName;
    }

}

