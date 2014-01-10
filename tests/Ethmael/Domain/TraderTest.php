<?php

namespace Ethmael\Domain;

class TraderTest extends \PHPUnit_Framework_TestCase
{
    protected $trader;

    public function setUp()
    {
        $this->trader = new Trader(Trader::WOOD, 10, 12);
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough quantity
     */
    public function traderCannotSellMoreThanItsQuantity()
    {
        $dreadPirateRoberts = new Pirate();
        $this->trader->sell($dreadPirateRoberts, 40);
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
        $this->trader->sell($dreadPirateRoberts, 8);
    }

    /**
     * @test
     */
    public function quantityStockDecreasesWhenTraderSells()
    {
        $roberts = new Pirate();
        $roberts->giveGold(500);
        $this->trader->sell($roberts, 4);
        $this->assertEquals(8, $this->trader->getQuantity());
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