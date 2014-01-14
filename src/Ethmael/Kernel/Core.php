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

        $saigon = new City($this->config);
        $saigon->newCityName($ville1);
        $saigon->newCityDescription("Les Charmes de l'Asie, capitale du commerce, haaaaa Saigon !");

        $luigi = new Trader($this->config);
        $luigi->initTrader(Cst::WOOD, 10, 500);
        $luigi->changeTraderName("luigi");

        $mario = new Trader($this->config);
        $mario->initTrader(Cst::JEWELS, 1000, 80);
        $mario->changeTraderName("mario");

        $saigon->addShop($luigi);
        $saigon->addShop($mario);

        $puertoRico = new City($this->config);
        $puertoRico->newCityName($ville2);
        $trader1 = new Trader($this->config);
        $trader1->initTrader(Cst::WOOD, 15, 300);

        $trader2 = new Trader($this->config);
        $trader2->initTrader(Cst::JEWELS, 600, 50);

        $puertoRico->addShop($trader1);
        $puertoRico->addShop($trader2);

        $game->addCity($saigon);
        $game->addCity($puertoRico);
    }

    public function initPirate($game)
    {
        $pirate = new Pirate($this->config);
        $pirate->giveGold(500000);
        $pirate->buyNewBoat();
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