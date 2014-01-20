<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class GameTest extends \PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->config = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");
    }

    /**
     * @test
     */
    public function newGameHasNoCity()
    {
        $game = new Game($this->config);
        $this->assertEquals(0,$game->countCity());
    }

    /**
     * @test
     */
    public function GameHasTwoCitiesAfterAddingTwoCities()
    {
        $ofThrones = new Game($this->config);

        $saigon = new City($this->config);
        $saigon->changeCityName("Saigon");
        $wood = new Trader($this->config);
        $wood->initTrader("","","Bois", 10);
        $saigon->addShop($wood);
        $ofThrones->addCity($saigon);

        $PuertoRico = new City($this->config);
        $PuertoRico->changeCityName("Puerto Rico");
        $wood2 = new Trader($this->config);
        $wood2->initTrader("","","Bois", 10);
        $PuertoRico->addShop($wood2);
        $ofThrones->addCity($PuertoRico);

        $this->assertEquals(2,$ofThrones->countCity());
    }

    /**
     * @test

    public function WeCanRetrieveACityByTheName()
    {
        $ofThrones = new Game($this->config);

        $saigon = new City($this->config);
        $saigon->changeCityName("Saigon");
        $ofThrones->addCity($saigon);

        $PuertoRico = new City($this->config);
        $ofThrones->addCity($PuertoRico);

        $cityRetrieved = $ofThrones->getCityWithName("Saigon");
        $this->assertEquals("Saigon",$cityRetrieved->showCityName());
    }*/


    /**
     * @test
     */
    public function GameHasOnePirateAfterAddingOnePirate()
    {
        $ofThrones = new Game($this->config);

        $pirate = new Pirate($this->config);
        $ofThrones->addPirate($pirate);

        $newPirate = $ofThrones->getPirate();
        $this->assertEquals($pirate,$newPirate);
    }


}