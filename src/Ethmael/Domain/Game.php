<?php

namespace Ethmael\Domain;

class Game
{
    protected $cities;

    public function __construct()
    {
        $this->cities = [];
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
}
