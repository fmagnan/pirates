<?php


namespace Ethmael\Domain;


class Settings {

    protected $configFile;
    protected $parameters;
    protected $cities;
    protected $resources;
    protected $traders;
    protected $boats;

    const PARAMETERS = "Parameters";
    const NBCITIES = "nbCities";
    const NBTURN = "nbTurn";

    const CITIES = "Cities";
    const CITYNAME = 0;
    const CITYDESCRIPTION = 1;

    const RESOURCES = "Resources";
    const RESOURCENAME = 0;
    const RESOURCELEVEL = 1;
    const RESOURCEBASICPRICE = 2;

    const TRADERS = "Traders";
    const TRADERNAME = 0;
    const TRADERWELCOMEMSG = 1;

    const BOATS = "Boats";
    const BOATNAME = 0;

    public function __construct($path)
    {
        $yaml = new \Symfony\Component\Yaml\Parser();
        try {
            $config = $yaml->parse(file_get_contents($path));
        } catch (\Symfony\Component\Yaml\Exception\ParseException $e) {
            printf("Unable to parse configuration file : %s", $e->getMessage());
            exit;
        }
        $this->configFile = $config;
        $this->parameters = $this->configFile[$this::PARAMETERS];
        $this->cities = $this->configFile[$this::CITIES];
        $this->resources = $this->configFile[$this::RESOURCES];
        $this->traders = $this->configFile[$this::TRADERS];
        $this->boats = $this->configFile[$this::BOATS];
    }

    public function getAllCities()
    {
        return $this->cities;
    }

    public function getCityName($num)
    {
        return $this->cities[$num][$this::CITYNAME];
    }

    public function getCityDescription($num)
    {
        return $this->cities[$num][$this::CITYDESCRIPTION];
    }

    public function getAllTraders()
    {
        return $this->traders;
    }

    public function getTraderName($num)
    {
        return $this->traders[$num][$this::TRADERNAME];
    }

    public function getTraderWelcomeMsg($num)
    {
        return $this->traders[$num][$this::TRADERWELCOMEMSG];
    }

    public function getAllResources()
    {
        return $this->resources;
    }

    public function getResourceName($num)
    {
        return $this->resources[$num][$this::RESOURCENAME];
    }

    public function getResourceLevel($num)
    {
        return $this->resources[$num][$this::RESOURCELEVEL];
    }

    public function getResourceBasicPrice($num)
    {
        return $this->resources[$num][$this::RESOURCEBASICPRICE];
    }

    public function getAllBoats()
    {
        return $this->boats;
    }

    public function getBoatName($num)
    {
        return $this->boats[$num][$this::BOATNAME];
    }

    public function getRandomBoatName()
    {
        $nb = count($this->boats);
        return $this->getBoatName(rand(0,$nb-1));
    }

    public function getAllParameters()
    {
        return $this->parameters;
    }

    public function getParameterNbTurn()
    {
        return $this->parameters[$this::NBTURN];
    }

    public function getParameterNbCities()
    {
        return $this->parameters[$this::NBCITIES];
    }
} 