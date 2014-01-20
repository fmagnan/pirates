<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class GameTest extends \PHPUnit_Framework_TestCase
{
    protected $settings;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->settings = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");
    }

    /**
     * @test
     */
    public function newGameHasNoCity()
    {
        $game = new Game($this->settings);
        $this->assertEquals(0,$game->countCity());
    }

    /**
     * @test
     */
    public function startedGameHasANumberOfCityDefinedInSettings()
    {
        $game = new Game($this->settings);
        $nbCities = $this->settings->getParameterNbCities();
        $game->startGame();
        $this->assertEquals($nbCities,$game->countCity());
    }

    /**
     * @test
     */
    public function GameHasOnePirateAfterAddingOnePirate()
    {
        $ofThrones = new Game($this->settings);

        $pirate = new Pirate($this->settings);
        $ofThrones->addPirate($pirate);

        $newPirate = $ofThrones->getPirate();
        $this->assertEquals($pirate,$newPirate);
    }


}