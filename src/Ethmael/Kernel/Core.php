<?php

namespace Ethmael\Kernel;

use Ethmael\Domain\City;
use Ethmael\Domain\Cst;
use Ethmael\Domain\Pirate;
use Ethmael\Domain\Trader;
use Ethmael\Utils\Math;

class Core
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function initCities($game, $nbCities = 12)
    {
        $cities = $this->config->getParam("CityName");
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
        $traders = $this->config->getParam("TraderName");
        $resources = $this->config->getParam("ResourceName");
        $nbResources = count($resources);

        //$liste = Math::randomN($nbTraders, 0, count($traders) - 1);

        $cities = $game->getCities();

        foreach ($cities as $city){
            for ($i = 0; $i < $nbResources; $i++) {
                $traderName = $traders[$i][0];
                $traderWelcomeMsg = $traders[$i][1];
                $resourceToSell = $resources[$i][0];
                $basicResourcePrice = $resources[$i][2];
                $newTrader = new Trader($this->config);
                $newTrader->changeTraderName($traderName);
                $newTrader->changeWelcomeMessage($traderWelcomeMsg);
                $newTrader->changeResourceToSell($resourceToSell,$basicResourcePrice);
                $newTrader->provisionResource(100);
                $city->addShop($newTrader);
            }
            //print_r($city->getAvailableTraders());
        }
    }

    /*
     * Resource lvl 1 : sold in 5 cities
     * Resource lvl 2 : sold in 4 cities
     * Resource lvl 3 : sold in 4 cities
     */
    public function dispatchTraders($game)
    {
        $resources = $this->config->getParam("ResourceName");
        foreach ($resources as $res){
            if ($res[1] == 1){
                $resLVL1[] = $res[0];
            }
            elseif ($res[1] == 2){
                $resLVL2[] = $res[0];
            }
            elseif ($res[1] == 3){
                $resLVL3[] = $res[0];
            }
        }

        $cities = $game->getCities();

        foreach ($resLVL1 as $res){
            $numCities = Math::randomN(5, 0, count($cities) - 1);
            foreach ($numCities as $numCity) {
                $cities[$numCity]->OpenShop($res);
            }
        }

        foreach ($resLVL2 as $res){
            $numCities = Math::randomN(4, 0, count($cities) - 1);
            foreach ($numCities as $numCity) {
                $cities[$numCity]->OpenShop($res);
            }
        }

        foreach ($resLVL3 as $res){
            $numCities = Math::randomN(4, 0, count($cities) - 1);
            foreach ($numCities as $numCity) {
                $cities[$numCity]->OpenShop($res);
            }
        }
        $game->newResourceEvaluation();

    }

    public function initPirate($game)
    {
        $pirate = new Pirate($this->config);
        $pirate->giveGold(1000);
        $pirate->buyNewBoat();
        $cities = $game->getCities();
        $pirate->setLocation($cities[0]);
        $game->addPirate($pirate);

        return $pirate;
    }
/*
    public function buyResourcetoTrader($game, $traderName, $quantity)
    {
        $pirate = $game->getPirate();
        $place = $pirate->isLocatedIn()->showCityName();
        $city = $game->getCityWithName($place);
        $trader = $city->getTraderByName($traderName);
        $trader->sell($pirate, $quantity);

        return $trader;
    }
*/
    public function sellResourcetoTrader($game, $traderName, $quantity)
    {
        $pirate = $game->getPirate();
        $place = $pirate->isLocatedIn()->showCityName();
        $city = $game->getCityWithName($place);
        $trader = $city->getTraderByName($traderName);
        $trader->buy($pirate, $quantity);

        return $trader;
    }
}