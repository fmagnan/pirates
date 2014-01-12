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
        $this->config = Config::loadConfigFile($projectRootPath . "data.yml");
    }

    /**
     * @test
     */
    public function decreasePurseAmount()
    {
        $jackSparrow = new Pirate($this->config);
        $jackSparrow->giveGold(50);
        $jackSparrow->takeGold(38);
        $this->assertEquals(12, $jackSparrow->countGold());
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
    public function PirateIsAbleToBuyNewBoat()
    {
        $albator = new Pirate($this->config);
        $albator->buyNewBoat("Arcadia");
        $this->assertEquals("Arcadia", $albator->boatName());
    }

    /**
     * @test
     */
    public function PirateInSaigonCanDrinkBearInSaigon()
    {
        $albator = new Pirate($this->config);
        $saigon = new City("Saigon");

        $albator->setLocation($saigon);
        $this->assertEquals("Saigon", $albator->isLocatedIn()->name());
    }


}