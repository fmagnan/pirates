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

    public function initCities($game, $nbCities = 2)
    {
        $cities = $this->config["CityName"];
        $liste = Math::randomN($nbCities, 0, count($cities) - 1);

        for ($i = 0; $i < $nbCities; $i++) {
            $cityName = $cities[$liste[$i]];
            $newCity = new City($this->config);
            $newCity->newCityName($cityName);
            $game->addCity($newCity);
        }

        //print_r ($game->getCities());
    }

    /*
     * Put nbTrader in each city
     */
    public function initTraders($game, $nbTraders = 2)
    {
        $traders = $this->config["TraderName"];
        $liste = Math::randomN($nbTraders, 0, count($traders) - 1);

        $cities = $game->getCities();

        foreach ($cities as $city){
            for ($i = 0; $i < $nbTraders; $i++) {
                $traderName = $traders[$liste[$i]];
                $newTrader = new Trader($this->config);
                $newTrader->changeTraderName($traderName);
                $city->addShop($newTrader);
            }
            //print_r($city->getAvailableTraders());
        }
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