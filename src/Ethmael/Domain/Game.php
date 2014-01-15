<?php

namespace Ethmael\Domain;

class Game
{
    protected $cities;
    protected $pirate;
    protected $currentTurn;
    protected $gameLength;

    public function __construct()
    {
        $this->cities = [];
        $this->pirate=null;
        $this->gameLength = 5;
        $this->currentTurn = 1;
    }

    public function countCity()
    {
        $numberOfCity = count($this->cities);
        return $numberOfCity;
    }

    public function addCity($city)
    {
        $this->cities[] = $city;
    }

    public function addPirate($pirate)
    {
        $this->pirate = $pirate;
    }

    public function getPirate()
    {
        return $this->pirate;
    }
    public function getCities()
    {
        return $this->cities;
    }

    public function getCityWithName($name)
    {
        foreach ($this->cities as $value) {
            if ($value->showCityName() == $name) {
                return $value;
            }
        }
        return false;
    }

    public function newTurn()
    {
        if ($this->currentTurn == $this->gameLength) {
            $message = sprintf('End of game.');
            throw new \RangeException($message);
        }

        $this->currentTurn += 1;
    }

    public function showCurrentTurn()
    {
        return $this->currentTurn;
    }

}
