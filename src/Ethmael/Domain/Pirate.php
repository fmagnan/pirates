<?php

namespace Ethmael\Domain;

class Pirate
{

    protected $gold;
    protected $boat;
    protected $currentCity;
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

    public function showGold()
    {
        return $this->gold;
    }

    public function buyNewBoat()
    {
        $newBoat = new Boat($this->gameConfig);
        $this->boat = $newBoat;
    }

    public function changeBoatName($name)
    {
        $this->boat->changeName($name);
    }

    public function showBoatName()
    {
        return $this->boat->showBoatName();
    }

    public function setLocation ($city) {
        if ($this->currentCity == $city) {
            $message = sprintf('You are already into this city (%s) do not exists.',$city->showCityName());
            throw new \Exception($message);
        }
        $this->currentCity = $city;
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

}