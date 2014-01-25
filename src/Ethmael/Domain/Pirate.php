<?php

namespace Ethmael\Domain;


class Pirate extends LifeForm
{


    protected $boat;
    protected $currentCity;
    protected $visitedCities = array();
    protected $settings;

    public function __construct($config)
    {
        $this->settings = $config;
        $this->gold = 0;
    }

    public function initPirate(City $city)
    {
        $this->giveGold($this->settings->getParameterStartingGold());
        $this->buyNewBoat($this->settings->getRandomBoatName());
        $this->setLocation($city);
    }

    /*
     * TODO launch new turn for the pirate (in the boat)
     */
    public function newTurn($turn)
    {
        $this->boat->newTurn($turn);
    }


    public function buyNewBoat($name)
    {
        $newBoat = new Boat($this->settings, $name);
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

    /*
     * -----  SHOW METHOD
     */
    public function showBoatCapacity()
    {
        return $this->boat->showCapacity();
    }

    public function showStock($resourceName = 'allStock')
    {
        return $this->boat->showStock($resourceName);
    }

    public function showBoatName()
    {
        return $this->boat->showBoatName();
    }

    public function showGold()
    {
        return $this->gold;
    }

    /*
     * -----  CHANGE METHOD
     */
    public function changeBoatName($name)
    {
        $this->boat->changeName($name);
    }
}