<?php


namespace Ethmael\Domain;

use Ethmael\Utils\Math;

class Map {

    protected $settings;
    protected $cities;

    public function __construct(Settings $setting)
    {
        $this->settings = $setting;
    }

    public function initMap()
    {
        $nbCities = $this->settings->getParameterNbCities();
        $cityList = $this->settings->getAllCities();
        $randomNum = Math::randomN($nbCities, 0, count($cityList) - 1);

        for ($i = 0; $i < $nbCities; $i++) {
            $cityName = $this->settings->getCityName($randomNum[$i]);
            $cityDesc = $this->settings->getCityDescription($randomNum[$i]);

            $newCity = new City($this->settings, $cityName, $cityDesc);
            $newCity->initCity($cityName, $cityDesc);
            $this->cities[] = $newCity;
        }

        $this->dispatchTraders();
        $this->newResourceEvaluation();
    }

    /*
     * Resource lvl 1 : sold in 5 cities
     * Resource lvl 2 : sold in 4 cities
     * Resource lvl 3 : sold in 4 cities
     */
    public function dispatchTraders()
    {

        $resources = $this->settings->getAllResources();
        $nbResources = count($resources);

        for ($i=0; $i < $nbResources; $i++) {
            if ($this->settings->getResourceLevel($i) == 1) {
                $resLVL1[] = $this->settings->getResourceName($i);
            } elseif ($this->settings->getResourceLevel($i) == 2) {
                $resLVL2[] = $this->settings->getResourceName($i);
            } elseif ($this->settings->getResourceLevel($i) == 3) {
                $resLVL3[] = $this->settings->getResourceName($i);
            }
        }


        foreach ($resLVL1 as $res){
            $numCities = Math::randomN(5, 0, count($this->cities) - 1);
            foreach ($numCities as $numCity) {
                $this->cities[$numCity]->OpenShop($res);
            }
        }

        foreach ($resLVL2 as $res){
            $numCities = Math::randomN(4, 0, count($this->cities) - 1);
            foreach ($numCities as $numCity) {
                $this->cities[$numCity]->OpenShop($res);
            }
        }

        foreach ($resLVL3 as $res){
            $numCities = Math::randomN(4, 0, count($this->cities) - 1);
            foreach ($numCities as $numCity) {
                $this->cities[$numCity]->OpenShop($res);
            }
        }
    }

    public function newResourceEvaluation()
    {
        foreach ($this->cities as $city) {
            foreach ($city->getAvailableTraders() as $trader) {

                $basePrice = $trader->showBasePrice();
                $variation = Math::randomN(1, -20, 20);

                $newPrice = intval($basePrice + ($basePrice * $variation[0] / 100));
                $trader->changeActualPrice($newPrice);
            }
        }
    }

    public function getRandomCity()
    {
        $nbCities = count($this->cities);
        return $this->cities[rand(0,$nbCities - 1)];
    }

    public function getCities()
    {
        return $this->cities;
    }

    public function showCityList()
    {
        $message = "";
        foreach ($this->cities as $value) {
            $message = $message.' - '.$value->showCityName();
        }

        return $message.'.';
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
} 