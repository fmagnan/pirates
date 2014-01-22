<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class TraderTest extends \PHPUnit_Framework_TestCase
{
    protected $trader;
    protected $settings;


    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->settings = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");

        $this->trader = new Trader($this->settings);
        $this->trader->initTrader("Bob","Welcome","Bois", 10, 12);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Le marchand n'a pas assez
     */
    public function traderCannotSellMoreThanItsQuantity()
    {
        $dreadPirateRoberts = new Pirate($this->settings);
        $dreadPirateRoberts->buyNewBoat("toto");
        $this->trader->sell($dreadPirateRoberts, 40);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Pas assez de place
     */
    public function traderCannotSellToPirateWithoutFreeSpace()
    {
        $dreadPirateRoberts = new Pirate($this->settings);
        $dreadPirateRoberts->buyNewBoat("toto");
        $dreadPirateRoberts->giveGold(500);
        $dreadPirateRoberts->getBoat()->addResource("Bois",99);
        $this->trader->sell($dreadPirateRoberts, 2);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Pas assez d'or
     */
    public function traderCannotSellToPoorPirate()
    {
        $dreadPirateRoberts = new Pirate($this->settings);
        $dreadPirateRoberts->giveGold(50);
        $dreadPirateRoberts->buyNewBoat("toto");
        $this->trader->sell($dreadPirateRoberts, 8);
    }

    /**
     * @test
     */
    public function quantityStockDecreasesWhenTraderSells()
    {
        $roberts = new Pirate($this->settings);
        $roberts->buyNewBoat("toto");
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(8, $this->trader->showResourceAvailable());
    }

    /**
     * @test
     */
    public function pirateQuantityStockIncreaseWhenTraderSell()
    {
        $roberts = new Pirate($this->settings);
        $roberts->buyNewBoat("toto");
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(4, $roberts->getBoat()->showStock("Bois"));
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Vous n'avez pas assez de
     */
    public function traderCannotBuyToPirateWithoutResource()
    {
        $dreadPirateRoberts = new Pirate($this->settings);
        $dreadPirateRoberts->buyNewBoat("toto");
        $dreadPirateRoberts->giveGold(500);
        $dreadPirateRoberts->getBoat()->addResource("Bois",1);
        $this->trader->buy($dreadPirateRoberts, 2);
    }

    /**
 * @test
 */
    public function pirateStockDecreaseWhenTraderBuy()
    {
        $dreadPirateRoberts = new Pirate($this->settings);
        $dreadPirateRoberts->buyNewBoat("toto");
        $dreadPirateRoberts->giveGold(500);
        $dreadPirateRoberts->getBoat()->addResource("Bois",10);
        $this->trader->buy($dreadPirateRoberts, 2);
        $this->assertEquals(8, $dreadPirateRoberts->showBoatStock("Bois"));
    }

    /**
     * @test
     */
    public function traderCanProvisionOrRestroyResource()
    {
        $this->trader->destroyResource(10000);
        $this->assertEquals(0, $this->trader->showResourceAvailable());
        $this->trader->provisionResource(50);
        $this->assertEquals(50, $this->trader->showResourceAvailable());
        $this->trader->destroyResource(49);
        $this->assertEquals(1, $this->trader->showResourceAvailable());
        $this->trader->destroyResource(87);
        $this->assertEquals(0, $this->trader->showResourceAvailable());
    }

    /**
     * @test
     */
    public function traderNameCanBeChanged()
    {
        $this->trader->changeName("Luigi");
        $this->assertEquals("Luigi", $this->trader->showName());
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
    public function newTraderShopIsClosed()
    {
        $this->assertEquals(false, $this->trader->isOpen());
    }

    /**
     * @test
     */
    public function closingShopCloseIt()
    {
        $this->trader->closeShop();
        $this->assertEquals(false, $this->trader->isOpen());
    }

    /**
     * @test
     */
    public function atEightAMShopIsOpening()
    {
        $this->trader->openShop();
        $this->assertEquals(true, $this->trader->isOpen());
    }

}