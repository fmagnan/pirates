<?php

namespace Ethmael\Kernel;

use Ethmael\Domain\City;
use Ethmael\Domain\Cst;
use Ethmael\Domain\Pirate;
use Ethmael\Domain\Trader;

class Registry
{
    protected $entities;

    public function __construct()
    {
        $this->entities = [];
    }

    public function bind($entityName, $entity)
    {
        if (isset($this->entities[$entityName])) {
            $message = sprintf('Entity %s is already registered.', $entityName);
            throw new \Exception($message);
        }
        $this->entities[$entityName] = $entity;
    }

    public function getEntity($entityName)
    {
        if (!isset($this->entities[$entityName])) {
            $message = sprintf('Missing entity %s.', $entityName);
            throw new \Exception($message);
        }
        return $this->entities[$entityName];
    }

    public function initCities()
    {
        $game = $this->getEntity('game');
        $saigon = new City("Saigon");
        $saigon->newDescription("Les Charmes de l'Asie, capitale du commerce, haaaaa Saigon !");
        $luigi = new Trader(Cst::WOOD, 10, 500);
        $luigi->newName("luigi");
        $mario = new Trader(Cst::JEWELS, 1000, 80);
        $mario->newName("mario");
        $saigon->addTrader($luigi);
        $saigon->addTrader($mario);

        $puertoRico = new City("Puerto Rico");
        $woodInRico = new Trader(Cst::WOOD, 15, 300);
        $jewelsInRico = new Trader(Cst::JEWELS, 600, 50);
        $puertoRico->addTrader($woodInRico);
        $puertoRico->addTrader($jewelsInRico);

        $game->addCity($saigon);
        $game->addCity($puertoRico);
    }

    public function initPirate()
    {
        $game = $this->getEntity('game');
        $pirate = new Pirate();
        $pirate->giveGold(500000);
        $pirate->buyNewBoat("Petit Bateau en Mousse");
        //$pirate->getBoat()->addResource(Boat::WOOD,10);
        //$pirate->getBoat()->addResource(Boat::JEWELS,20);
        $pirate->setLocation($game->getCityWithName("Saigon"));
        $game->addPirate($pirate);
    }

    public function buyResourcetoTrader($traderName, $quantity)
    {
        $game = $this->getEntity('game');
        $pirate = $game->getPirate();
        $place = $pirate->isLocatedIn()->name();
        $city = $game->getCityWithName($place);
        $trader = $city->getTraderByName($traderName);
        $trader->sell($pirate, $quantity);

        return $trader;
    }

}