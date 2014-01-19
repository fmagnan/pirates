<?php

namespace Ethmael\Domain;

class City
{
    protected $cityName;
    protected $cityDescription;
    protected $traders;
    protected $settings; //Array with all parameters of the game.


    public function __construct(Settings $config)
    {
        $this->settings = $config;
        $this->traders = [];
        $this->changeCityName("nompardefaut");
        $this->changeCityDescription("desc par defaut");
    }

    public function initCity($cityName, $cityDescription)
    {
        $this->changeCityName($cityName);
        $this->changeCityDescription($cityDescription);
        $resources = $this->settings->getAllResources();
        $nbResources = count($resources);

        for ($i = 0; $i < $nbResources; $i++) {
            $traderName = $this->settings->getTraderName($i);
            $traderWelcomeMsg = $this->settings->getTraderWelcomeMsg($i);

            $resourceToSell = $this->settings->getResourceName($i);
            $basicResourcePrice = $this->settings->getResourceBasicPrice($i);

            $newTrader = new Trader($this->settings);
            $newTrader->initTrader($traderName,$traderWelcomeMsg,$resourceToSell,$basicResourcePrice,100);
            $this->addShop($newTrader);
        }

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

    public function countOpenShop()
    {
        $nbShopOpen = 0;
        foreach ($this->traders as $item){
            if ($item->isOpen()) {
                $nbShopOpen +=1;
            }
        }
        return $nbShopOpen;
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
            if ($traderName == $item->showTraderName()) {
                return $item;
            }
        }
        $message = sprintf("Ce marchand n'existe pas %s", $traderName);
        throw new \RangeException($message);
    }

    public function upgradeBoat(Pirate $pirate)
    {
        $actualBoatCapacity = $pirate->showBoatCapacity();
        $upgradePrice = $actualBoatCapacity * 20;
        $pirate->takeGold($upgradePrice);
        $boat = $pirate->getBoat();
        $boat->upgradeBoatLevel();
    }

    public function newCityName($name)
    {
        $this->cityName = $name;
    }

    public function newCityDescription($desc)
    {
        $this->cityDescription = $desc;
    }

    public function changeCityName($name)
    {
        $this->cityName = $name;
    }

    public function changeCityDescription($desc)
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

