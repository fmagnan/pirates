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

    public function initCities($game, $nbCities = 11)
    {
        $cities = $this->config["CityName"];
        $liste = Math::randomN($nbCities, 0, count($cities) - 1);

        for ($i = 0; $i < $nbCities; $i++) {
            $cityName = $cities[$liste[$i]][0];
            $cityDesc = $cities[$liste[$i]][1];
            $newCity = new City($this->config);
            $newCity->newCityName($cityName);
            $newCity->newCityDescription($cityDesc);
            $game->addCity($newCity);
        }

        //print_r ($this->config);
    }

    /*
     * create as many trader as available resources
     */
    public function initTraders($game)
    {
        $traders = $this->config["TraderName"];
        $resources = $this->config["ResourceName"];
        $nbResources = count($resources);

        //$liste = Math::randomN($nbTraders, 0, count($traders) - 1);

        $cities = $game->getCities();

        foreach ($cities as $city){
            for ($i = 0; $i < $nbResources; $i++) {
                $traderName = $traders[$i][0];
                $traderWelcomeMsg = $traders[$i][1];
                $resourceToSell = $resources[$i][0];
                $newTrader = new Trader($this->config);
                $newTrader->changeTraderName($traderName);
                $newTrader->changeWelcomeMessage($traderWelcomeMsg);
                $newTrader->changeResourceToSell($resourceToSell);
                $newTrader->provisionResource(100);
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