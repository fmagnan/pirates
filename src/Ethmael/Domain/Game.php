<?php

namespace Ethmael\Domain;

class Game
{
    protected $cities;
    protected $pirate;

    public function __construct()
    {
        $this->cities = [];
        $this->pirate=null;
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

}
