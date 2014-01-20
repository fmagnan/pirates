<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class PirateTest extends \PHPUnit_Framework_TestCase
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
    public function decreasePurseAmount()
    {
        $jackSparrow = new Pirate($this->config);
        $jackSparrow->giveGold(50);
        $jackSparrow->takeGold(38);
        $this->assertEquals(12, $jackSparrow->showGold());
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough gold
     */
    public function takeMoreGoldThanItsPurse()
    {
        $jackSparrow = new Pirate($this->config);
        $jackSparrow->takeGold(12);
    }

    /**
     * @test
     */
    public function PirateCanChangeBoatName()
    {
        $albator = new Pirate($this->config);
        $albator->buyNewBoat("toto");
        $albator->changeBoatName("Azerty");
        $this->assertEquals("Azerty", $albator->showBoatName());
    }

    /**
     * @test
     */
    public function PirateInSaigonCanDrinkBearInSaigon()
    {
        $albator = new Pirate($this->config);
        $saigon = new City($this->config);
        $saigon->newCityName("Saigon");

        $albator->setLocation($saigon);
        $this->assertEquals("Saigon", $albator->isLocatedIn()->showCityName());
    }


}