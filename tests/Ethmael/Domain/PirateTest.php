<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class PirateTest extends \PHPUnit_Framework_TestCase
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
    public function decreasePurseAmount()
    {
        $jackSparrow = new Pirate($this->settings);
        $jackSparrow->giveGold(50);
        $jackSparrow->takeGold(38);
        $this->assertEquals(12, $jackSparrow->showGold());
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Pas assez d'or
     */
    public function takeMoreGoldThanItsPurse()
    {
        $jackSparrow = new Pirate($this->settings);
        $jackSparrow->takeGold(12);
    }

    /**
     * @test
     */
    public function stealAllGoldOfPirate()
    {
        $jackSparrow = new Pirate($this->settings);
        $jackSparrow->giveGold(50);
        $jackSparrow->stealGold(75);
        $this->assertEquals(0, $jackSparrow->showGold());
    }

    /**
 * @test
 */
    public function PirateCanChangeBoatName()
    {
        $albator = new Pirate($this->settings);
        $albator->buyNewBoat("toto");
        $albator->changeBoatName("Azerty");
        $this->assertEquals("Azerty", $albator->showBoatName());
    }

    /**
     * @test
     */
    public function PirateCanUpgradeAndDowngradeHisBoat()
    {
        $albator = new Pirate($this->settings);
        $albator->buyNewBoat("toto");
        $this->assertEquals(100, $albator->showBoatCapacity());
        $albator->upgradeBoatLevel();
        $this->assertEquals(200, $albator->showBoatCapacity());
        $albator->downgradeBoatLevel();
        $this->assertEquals(100, $albator->showBoatCapacity());
    }

    /**
     * @test
     */
    public function PirateInSaigonCanDrinkBearInSaigon()
    {
        $albator = new Pirate($this->settings);
        $saigon = new City($this->settings);
        $saigon->changeCityName("Saigon");

        $albator->setLocation($saigon);
        $this->assertEquals("Saigon", $albator->isLocatedIn()->showCityName());
    }

    /**
 * @test
 */
    public function PirateRememberCitiesVisited()
    {
        $albator = new Pirate($this->settings);
        $saigon = new City($this->settings);
        $saigon->changeCityName("Saigon");
        $tortage = new City($this->settings);
        $tortage->changeCityName("Tortage");

        $albator->addVisitedCity($saigon);
        $cities = $albator->getVisitedCities();
        $this->assertEquals("Saigon", $cities[0]->showCityNAme());

        $albator->addVisitedCity($tortage);
        $cities = $albator->getVisitedCities();
        $this->assertEquals("Tortage", $cities[1]->showCityNAme());
    }

    /**
     * @test
     */
    public function PirateCanLooseAllStock()
    {
        $albator = new Pirate($this->settings);
        $albator->buyNewBoat("toto");
        $albator->giveResource("Bois", 300);
        $this->assertEquals(100, $albator->showBoatStock());
        $albator->looseStock();
        $this->assertEquals(0, $albator->showBoatStock());
    }


}