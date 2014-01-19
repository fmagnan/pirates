<?php

namespace Ethmael\Domain;

class Pirate
{

    protected $gold;
    protected $boat;
    protected $currentCity;
    protected $visitedCities = array();
    protected $gameConfig; //Array with all parameters of the game.

    /*
     * $config : game config file loaded in an array.
     */
    public function __construct($config)
    {
        $this->gameConfig = $config;
        $this->gold = 0;
    }


    public function giveGold($amount)
    {
        $this->gold += $amount;
        return $this->showGold();
    }


    public function takeGold($amount)
    {
        if ($amount > $this->gold) {
            $message = sprintf('not enough gold in purse to take %d', $amount);
            throw new \RangeException($message);
        }
        $this->gold -= $amount;

        return $this->showGold();
    }

    public function stealGold($amount)
    {

        if ($this->gold < $amount) {
            $this->gold = 0;
        }
        else {
            $this->gold -= $amount;
        }

        return $this->showGold();
    }

    public function showGold()
    {
        return $this->gold;
    }

    public function buyNewBoat()
    {
        $newBoat = new Boat($this->gameConfig);
        $this->boat = $newBoat;
    }

    public function upgradeBoatLevel()
    {
        $this->boat->upgradeBoatLevel();
    }

    public function downgradeBoatLevel()
    {
        $this->boat->downgradeBoatLevel();
    }

    public function changeBoatName($name)
    {
        $this->boat->changeName($name);
    }

    public function showBoatName()
    {
        return $this->boat->showBoatName();
    }

    public function setLocation (City $city) {
        if ($this->currentCity == $city) {
            $message = sprintf('You are already into this city (%s).',$city->showCityName());
            throw new \Exception($message);
        }
        $this->currentCity = $city;
        $this->addVisitedCity($city);
    }

    public function isLocatedIn () {
        return $this->currentCity;
    }

    public function getBoat()
    {
        return $this->boat;
    }

    public function showBoatCapacity()
    {
        return $this->boat->showCapacity();
    }

    public function showBoatStock($resource = null)
    {
        if ($resource == null){
            return $this->boat->showStock();
        }
        return $this->boat->showStock($resource);
    }

    public function getVisitedCities()
    {
        return $this->visitedCities;
    }

    public function addVisitedCity($newCity)
    {
        $found = false;

        foreach ($this->visitedCities as $city) {
            if ($city === $newCity) {
                $found = true;
            }
        }
        if ($found == false) {
            $this->visitedCities[]=$newCity;
        }

    }

    public function looseStock()
    {
        $this->boat->destroyStock();
    }

    public function giveResource($resourceName,$quantity)
    {
        $this->boat->addAsManyResourceAsPossible($resourceName,$quantity);
    }


}