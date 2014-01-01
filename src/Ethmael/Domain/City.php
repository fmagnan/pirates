<?php

namespace Ethmael\Domain;

class City
{

    protected $traders;

    public function __construct()
    {
        $this->traders = [];
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

}

