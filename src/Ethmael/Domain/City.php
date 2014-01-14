<?php

namespace Ethmael\Domain;

class City
{
    protected $cityName;
    protected $cityDescription;
    protected $traders;
    protected $gameConfig; //Array with all parameters of the game.


    public function __construct($config)
    {
        $this->gameConfig = $config;
        $this->traders = [];
        $this->cityName = "defaultName";
        $this->cityDescription = "Une ville quelconque";
    }



    public function getAvailableTraders()
    {
        return $this->traders;
    }

    public function addShop(Trader $trader)
    {
        $this->traders[] = $trader;
    }

    public function closeShop($resource)
    {
        foreach ($this->traders as $item){
            if ($item->showResource() == $resource) {
                $item->closeShop();
            }
        }
    }

    public function openShop($resource)
    {
        foreach ($this->traders as $item){
            if ($item->showResource() == $resource) {
                $item->openShop();
            }
        }
    }

    public function canDealWith($resource)
    {
        foreach ($this->traders as $item) {
            if ($resource == $item->showResource()) {
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

    public function newCityName($name)
    {
        $this->cityName = $name;
    }

    public function newCityDescription($desc)
    {
        $this->cityDescription = $desc;
    }

    public function showCityName()
    {
        return $this->cityName;
    }

    public function showCityDescription()
    {
        return $this->cityDescription;
    }

}

