<?php

namespace Ethmael\Kernel;

use Ethmael\Domain\City;
use Ethmael\Domain\Cst;
use Ethmael\Domain\Pirate;
use Ethmael\Domain\Trader;
use Ethmael\Utils\Math;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class Core
{

    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function initCities($game)
    {
        $cities = $this->config["CityName"];
        $liste = Math::randomN(2, 0, count($cities) - 1);

        $ville1 = $cities[$liste[0]];
        $ville2 = $cities[$liste[1]];

        $saigon = new City($ville1);
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

    public function initPirate($game)
    {
        $pirate = new Pirate($this->config);
        $pirate->giveGold(500000);
        $pirate->buyNewBoat("Petit Bateau en Mousse");
        //$pirate->getBoat()->addResource(Boat::WOOD,10);
        //$pirate->getBoat()->addResource(Boat::JEWELS,20);
        $cities = $game->getCities();
        $pirate->setLocation($cities[0]);
        $game->addPirate($pirate);

        return $pirate;
    }

    public function buyResourcetoTrader($game, $traderName, $quantity)
    {
        $pirate = $game->getPirate();
        $place = $pirate->isLocatedIn()->name();
        $city = $game->getCityWithName($place);
        $trader = $city->getTraderByName($traderName);
        $trader->sell($pirate, $quantity);

        return $trader;
    }
}