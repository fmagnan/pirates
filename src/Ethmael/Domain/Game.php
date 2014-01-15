<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;

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

        $message = sprintf('This City (%s) do not exists.',$name);
        throw new \Exception($message);

    }

    public function newTurn()
    {
        if ($this->currentTurn == $this->gameLength) {
            $message = sprintf('End of game.');
            throw new \Exception($message);
        }

        $this->currentTurn += 1;
        $this->newResourceEvaluation();
    }

    public function newResourceEvaluation()
    {
        foreach ($this->cities as $city) {
            foreach ($city->getAvailableTraders() as $trader) {
                $actualPrice = $trader->showActualPrice();
                $basePrice = $trader->showBasePrice();
                $variation = Math::randomN(1, -20, 20);

                $newPrice = $actualPrice + ($basePrice * $variation[0] / 100);
                $trader->changeActualPrice($newPrice);
            }
        }
    }

    public function showCurrentTurn()
    {
        return $this->currentTurn;
    }

}
