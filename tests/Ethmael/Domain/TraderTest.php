<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class TraderTest extends \PHPUnit_Framework_TestCase
{
    protected $trader;
    protected $config;


    public function setUp()
    {
        $this->trader = new Trader(Cst::WOOD, 10, 12);

        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->config = Config::loadConfigFile($projectRootPath . "data.yml");
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
        $this->assertEquals(8, $this->trader->getQuantity());
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
        $this->assertEquals(4, $roberts->getBoat()->getStock("Bois"));
    }

    /**
     * @test
     */
    public function traderNameCanBeChanged()
    {
        $this->trader->newName("Luigi");
        $this->assertEquals("Luigi", $this->trader->name());
    }

    /**
     * @test
     */
    public function traderWelcomeSentenceCanBeChanged()
    {
        $this->trader->newWelcome("Jourbon");
        $this->assertEquals("Jourbon", $this->trader->welcomeMessage());
    }

}