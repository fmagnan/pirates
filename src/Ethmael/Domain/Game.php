<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;
use Ethmael\Kernel\Response;

class Game
{
    protected $map;
    protected $cities;
    protected $pirate;
    protected $currentTurn;
    protected $gameLength;
    protected $settings;

    public function __construct($config)
    {
        $this->settings = $config;
        $this->map = new Map($this->settings);
        $this->pirate = new Pirate($this->settings);

        $this->cities = [];
        $this->gameLength = $this->showParamNbTurn();
        $this->currentTurn = 0;
    }


    public function startGame()
    {
        $this->map->initMap();
        $this->pirate->initPirate($this->map->getRandomCity());
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





    public function newTurn(Response $response)
    {
        if ($this->currentTurn == $this->gameLength) {

            $message = 'End of game. Score : '.$this->pirate->showGold();
            throw new \Exception($message);
        }

        $this->currentTurn += 1;
        $this->newResourceEvaluation();
        $event = new Event();
        $event->launchEvent($this->settings, rand(1,3),rand(1,12),$this->getCities(),$this->getPirate(),$response);
    }

    public function newResourceEvaluation()
    {
        foreach ($this->cities as $city) {
            foreach ($city->getAvailableTraders() as $trader) {
                $actualPrice = $trader->showActualPrice();
                $basePrice = $trader->showBasePrice();
                $variation = Math::randomN(1, -20, 20);

                $newPrice = intval($basePrice + ($basePrice * $variation[0] / 100));
                $trader->changeActualPrice($newPrice);
            }
        }
    }

    public function showCurrentTurn()
    {
        return $this->currentTurn;
    }

    public function showParamNbTurn()
    {
        $param = $this->settings->getAllParameters();
        return $param["nbTurn"];

    }

    public function getMap()
    {
        return $this->map;
    }
}
