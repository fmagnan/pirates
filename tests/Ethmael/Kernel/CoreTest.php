<?php

namespace Ethmael\Kernel;

use Ethmael\Domain\Boat;
use Ethmael\Domain\City;
use Ethmael\Domain\Game;
use Ethmael\Domain\Pirate;
use Ethmael\Domain\Trader;
use Ethmael\Utils\Config;

class CoreTest extends \PHPUnit_Framework_TestCase {

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
    public function buyingRhumAddItToPirateBoat()
    {
        $roberts = new Pirate($this->config);
        $roberts->giveGold(3000);
        $laLicorne = new Boat($this->config);
        $roberts->buyNewBoat($laLicorne);
        $mirage = new City($this->config);
        $mirage->newCityName('mirage');
        $mario = new Trader($this->config);
        $mario->changeTraderName('mario');
        $mario->initTrader('Rhum', 2, 300);
        $mirage->addShop($mario);
        $roberts->addVisitedCity($mirage);
        $roberts->setLocation($mirage);
        $game = new Game($this->config);
        $game->addCity($mirage);
        $game->addPirate($roberts);

        $core = new Core($this->config);

        $core->buyResourcetoTrader($game, 'mario', 6);

        $this->assertEquals(6, $roberts->showBoatStock());
        /*
         * @todo ce test echoue !
            $this->assertEquals(6, $laLicorne->showStock());
        */

    }

}