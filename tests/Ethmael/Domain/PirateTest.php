<?php

namespace Ethmael\Domain;

class PirateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function decreasePurseAmount()
    {
        $jackSparrow = new Pirate();
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
        $jackSparrow = new Pirate();
        $jackSparrow->takeGold(12);
    }

    /**
     * @test
     */
    public function PirateIsAbleToBuyNewBoat()
    {
        $albator = new Pirate();
        $albator->buyNewBoat("Arcadia");
        $this->assertEquals("Arcadia", $albator->boatName());
    }


}