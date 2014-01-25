<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;
use Ethmael\Kernel\Response;

class Game
{
    protected $map;
    //protected $cities;
    protected $pirate;
    protected $currentTurn;
    protected $gameLength;
    protected $settings;

    public function __construct($config)
    {
        $this->settings = $config;
        $this->map = new Map($this->settings);
        $this->pirate = new Pirate($this->settings);

        //$this->cities = [];
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
        $numberOfCity = count($this->getCities());
        return $numberOfCity;
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
        return $this->map->getCities();
    }

    /*
     * TODO launch new turn in map & pirate
     */
    public function newTurn(Response $response)
    {
        if ($this->currentTurn == $this->gameLength) {
            $message = 'End of game. Score : '.$this->pirate->showGold();
            throw new \Exception($message);
        }

        $this->currentTurn += 1;

        $this->map->newTurn($this->currentTurn);
        $this->pirate->newTurn($this->currentTurn);
        $event = new Event($this->settings);
        $message = $event->launchEvent(rand(1,3),rand(1,10),$this->getCities(),$this->getPirate());
        $response->addLine($message);
    }

    public function showCurrentTurn()
    {
        return $this->currentTurn;
    }

    public function showParamNbTurn()
    {
        return $this->settings->getParameterNbTurn();
    }

    public function getMap()
    {
        return $this->map;
    }
}
