<?php

namespace Ethmael\Domain;

class City
{
    protected $cityName;
    protected $cityDescription;
    protected $traders;


    public function __construct($name="defaultName")
    {
        $this->traders = [];
        $this->cityName = $name;
        $this->cityDescription = "une ville quelconque";
    }

    public function newName($name)
    {
        $this->cityName = $name;
    }

    public function newDescription($desc)
    {
        $this->cityDescription = $desc;
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

    public function getTraderByName($traderName)
    {
        foreach ($this->traders as $item) {
            if ($traderName == $item->name()) {
                return $item;
            }
        }
        $message = sprintf("Ce marchand n''existe pas %s", $traderName);
        throw new \RangeException($message);
    }

    public function name()
    {
        return $this->cityName;
    }

    public function description()
    {
        return $this->cityDescription;
    }

}

