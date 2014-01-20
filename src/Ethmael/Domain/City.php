<?php

namespace Ethmael\Domain;

class City
{
    protected $cityName;
    protected $cityDescription;
    protected $traders;
    protected $settings;

    public function __construct(Settings $config, $name="montpellier", $desc="Wow")
    {
        $this->settings = $config;
        $this->traders = [];
        $this->changeCityName($name);
        $this->changeCityDescription($desc);
    }

    public function initCity()
    {
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

    public function getTraderByName($traderName)
    {
        foreach ($this->traders as $item) {
            if ($traderName == $item->showTraderName()) {
                return $item;
            }
        }
        $message = sprintf("Trader does not exist : %s.", $traderName);
        throw new \Exception($message);
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

    public function upgradeBoat(Pirate $pirate)
    {
        $actualBoatCapacity = $pirate->showBoatCapacity();
        $upgradePrice = $actualBoatCapacity * 20;
        $pirate->takeGold($upgradePrice);
        $pirate->upgradeBoatLevel();
    }

    /*
     * -----  SHOW METHOD
     */
    public function showCityName()
    {
        return $this->cityName;
    }

    public function showCityDescription()
    {
        return $this->cityDescription;
    }

    /*
     * -----  CHANGE METHOD
     */
    public function changeCityName($name)
    {
        $this->cityName = $name;
    }

    public function changeCityDescription($desc)
    {
        $this->cityDescription = $desc;
    }
}

