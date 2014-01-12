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
        $this->config = Config::loadConfigFile($projectRootPath . "data.yml");
    }

    /**
     * @test
     */
    public function newGameHasNoCity()
    {
        $game = new Game();
        $this->assertEquals(0,$game->countCity());
    }

    /**
     * @test
     */
    public function GameHasTwoCitiesAfterAddingTwoCities()
    {
        $ofThrones = new Game();

        $saigon = new City("Saigon");
        $wood = new Trader(Cst::WOOD, 10);
        $saigon->addTrader($wood);
        $ofThrones->addCity($saigon);

        $PuertoRico = new City("Puerto Rico");
        $wood = new Trader(Cst::WOOD, 10);
        $PuertoRico->addTrader($wood);
        $ofThrones->addCity($PuertoRico);

        $this->assertEquals(2,$ofThrones->countCity());
    }

    /**
     * @test
     */
    public function WeCanRetrieveACityByTheName()
    {
        $ofThrones = new Game();

        $saigon = new City("Saigon");
        $ofThrones->addCity($saigon);

        $PuertoRico = new City("Puerto Rico");
        $ofThrones->addCity($PuertoRico);

        $cityRetrieved = $ofThrones->getCityWithName("Saigon");
        $this->assertEquals("Saigon",$cityRetrieved->name());
    }


    /**
     * @test
     */
    public function GameHasOnePirateAfterAddingOnePirate()
    {
        $ofThrones = new Game();

        $pirate = new Pirate($this->config);
        $ofThrones->addPirate($pirate);

        $newPirate = $ofThrones->getPirate();
        $this->assertEquals($pirate,$newPirate);
    }


}