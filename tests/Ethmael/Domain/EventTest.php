<?php

namespace Ethmael\Domain;


class EventTest extends \PHPUnit_Framework_TestCase {


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
    public function pirateWinMoneyWithGoodGoldEvent()
    {
        $map = new Map($this->settings);
        $map->initMap();
        $pirate = new Pirate($this->settings);
        $pirate->buyNewBoat("toto");
        $pirate->giveGold(1000);
        $event = new Event($this->settings);
        $event->launchEvent(1,1,$map->getCities(),$pirate);
        $this->assertGreaterThan(1000, $pirate->showGold());
    }

    /**
     * @test
     */
    public function pirateLooseMoneyWithBadGoldEvent()
    {
        $map = new Map($this->settings);
        $map->initMap();
        $pirate = new Pirate($this->settings);
        $pirate->buyNewBoat("toto");
        $pirate->giveGold(1000);
        $event = new Event($this->settings);
        $event->launchEvent(1,10,$map->getCities(),$pirate);
        $this->assertLessThan(1000, $pirate->showGold());
    }

    /**
     * @test
     */
    public function pirateUpgradeHisBoatWithGoodBoatEvent()
    {
        $map = new Map($this->settings);
        $map->initMap();
        $pirate = new Pirate($this->settings);
        $pirate->buyNewBoat("toto");
        $pirate->giveGold(1000);
        $event = new Event($this->settings);
        $event->launchEvent(2,1,$map->getCities(),$pirate);
        $this->assertEquals(200, $pirate->showBoatCapacity());
    }

    /**
     * @test
     */
    public function pirateDowngradeHisBoatWithBadBoatEvent()
    {
        $map = new Map($this->settings);
        $map->initMap();
        $pirate = new Pirate($this->settings);
        $pirate->buyNewBoat("toto");
        $pirate->giveGold(1000);
        $this->assertEquals(100, $pirate->showBoatCapacity());
        $pirate->upgradeBoatLevel();
        $this->assertEquals(200, $pirate->showBoatCapacity());
        $event = new Event($this->settings);
        $event->launchEvent(2,10,$map->getCities(),$pirate);
        $this->assertEquals(100, $pirate->showBoatCapacity());
    }

    /**
     * @test
     */
    public function pirateWinResourceWithGoodStockEvent()
    {
        $map = new Map($this->settings);
        $map->initMap();
        $pirate = new Pirate($this->settings);
        $pirate->buyNewBoat("toto");
        $this->assertEquals(0, $pirate->showBoatStock());
        $event = new Event($this->settings);
        $event->launchEvent(3,1,$map->getCities(),$pirate);
        $this->assertGreaterThan(0, $pirate->showBoatStock());
    }
}
 