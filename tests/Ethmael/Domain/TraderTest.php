<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class TraderTest extends \PHPUnit_Framework_TestCase
{
    protected $trader;
    protected $config;


    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->config = Config::loadConfigFile($projectRootPath . "data.yml");

        $this->trader = new Trader($this->config);
        $this->trader->initTrader(Cst::WOOD, 10, 12);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough quantity
     */
    public function traderCannotSellMoreThanItsQuantity()
    {
        $dreadPirateRoberts = new Pirate($this->config);
        $dreadPirateRoberts->buyNewBoat();
        $this->trader->sell($dreadPirateRoberts, 40);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough space
     */
    public function traderCannotSellToPirateWithoutFreeSpace()
    {
        $dreadPirateRoberts = new Pirate($this->config);
        $dreadPirateRoberts->buyNewBoat();
        $dreadPirateRoberts->giveGold(500);
        $dreadPirateRoberts->getBoat()->addResource("Bois",99);
        $this->trader->sell($dreadPirateRoberts, 2);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough gold
     */
    public function traderCannotSellToPoorPirate()
    {
        $dreadPirateRoberts = new Pirate($this->config);
        $dreadPirateRoberts->giveGold(50);
        $dreadPirateRoberts->buyNewBoat();
        $this->trader->sell($dreadPirateRoberts, 8);
    }

    /**
     * @test
     */
    public function quantityStockDecreasesWhenTraderSells()
    {
        $roberts = new Pirate($this->config);
        $roberts->buyNewBoat();
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(8, $this->trader->showResourceAvailable());
    }

    /**
     * @test
     */
    public function pirateQuantityStockIncreaseWhenTraderSells()
    {
        $roberts = new Pirate($this->config);
        $roberts->buyNewBoat();
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(4, $roberts->getBoat()->showStock("Bois"));
    }

    /**
     * @test
     */
    public function traderNameCanBeChanged()
    {
        $this->trader->changeTraderName("Luigi");
        $this->assertEquals("Luigi", $this->trader->showTraderName());
    }

    /**
     * @test
     */
    public function traderWelcomeSentenceCanBeChanged()
    {
        $this->trader->changeWelcomeMessage("Jourbon");
        $this->assertEquals("Jourbon", $this->trader->showWelcomeMessage());
    }

    /**
     * @test
     */
    public function newTraderShopIsOpen()
    {
        $this->assertEquals(true, $this->trader->isOpen());
    }

    /**
     * @test
     */
    public function closingShopCloseIt()
    {
        $this->trader->closeShop();
        $this->assertEquals(false, $this->trader->isOpen());
    }

}