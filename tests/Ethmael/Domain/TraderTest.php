<?php

namespace Ethmael\Domain;

class TraderTest extends \PHPUnit_Framework_TestCase
{
    protected $trader;

    public function setUp()
    {
        $this->trader = new Trader(Cst::WOOD, 10, 12);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough quantity
     */
    public function traderCannotSellMoreThanItsQuantity()
    {
        $dreadPirateRoberts = new Pirate();
        $dreadPirateRoberts->buyNewBoat("France");
        $this->trader->sell($dreadPirateRoberts, 40);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough space
     */
    public function traderCannotSellToPirateWithoutFreeSpace()
    {
        $dreadPirateRoberts = new Pirate();
        $dreadPirateRoberts->buyNewBoat("France");
        $dreadPirateRoberts->giveGold(500);
        $dreadPirateRoberts->getBoat()->addResource(Cst::WOOD,99);
        $this->trader->sell($dreadPirateRoberts, 2);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough gold
     */
    public function traderCannotSellToPoorPirate()
    {
        $dreadPirateRoberts = new Pirate();
        $dreadPirateRoberts->giveGold(50);
        $dreadPirateRoberts->buyNewBoat("France");
        $this->trader->sell($dreadPirateRoberts, 8);
    }

    /**
     * @test
     */
    public function quantityStockDecreasesWhenTraderSells()
    {
        $roberts = new Pirate();
        $roberts->buyNewBoat("France");
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(8, $this->trader->getQuantity());
    }

    /**
     * @test
     */
    public function pirateQuantityStockIncreaseWhenTraderSells()
    {
        $roberts = new Pirate();
        $roberts->buyNewBoat("France");
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(4, $roberts->getBoat()->getStock(Cst::WOOD));
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