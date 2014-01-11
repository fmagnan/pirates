<?php

namespace Ethmael\Kernel;

use Ethmael\Domain\City;
use Ethmael\Domain\Game;
use Ethmael\Domain\Pirate;
use Ethmael\Domain\Player;
use Ethmael\Domain\Trader;

class Registry
{
    protected $player;
    protected $game;

    public function getPlayer()
    {
        return $this->player;
    }

    public function getGame()
    {
        return $this->game;
    }

    public function bindGame(Game $game)
    {
        $this->game = $game;
    }

    public function bindPlayer(Player $player)
    {
        $this->player = $player;
    }

    public function initCities()
    {
        $saigon = new City("Saigon");
        $saigon->newDescription("Les Charmes de l'Asie, capitale du commerce, haaaaa Saigon !");
        $luigi = new Trader(Trader::WOOD, 10, 500);
        $luigi->newName("Luigi");
        $mario = new Trader(Trader::JEWELS, 1000, 80);
        $mario->newName("Mario");
        $saigon->addTrader($luigi);
        $saigon->addTrader($mario);

        $puertoRico = new City("Puerto Rico");
        $woodInRico = new Trader(Trader::WOOD, 15, 300);
        $jewelsInRico = new Trader(Trader::JEWELS, 600, 50);
        $puertoRico->addTrader($woodInRico);
        $puertoRico->addTrader($jewelsInRico);

        $this->game->addCity($saigon);
        $this->game->addCity($puertoRico);
    }

    public function initPirate()
    {
        $pirate = new Pirate();
        $pirate->giveGold(500000);
        $pirate->buyNewBoat("Petit Bateau en Mousse");
        //$pirate->getBoat()->addResource(Boat::WOOD,10);
        //$pirate->getBoat()->addResource(Boat::JEWELS,20);
        $pirate->setLocation($this->game->getCityWithName("Saigon"));
        $this->game->addPirate($pirate);
    }

}