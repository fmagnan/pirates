<?php

namespace Ethmael\Domain;

class TraderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function defaultTraderDealsWood()
    {
        $trader = new Trader();
        $this->assertEquals(Trader::WOOD, $trader->getType());
    }

    /**
     * @test
     */
    public function defaultTraderHasAnEmptyStock()
    {
        $trader = new Trader();
        $this->assertEquals(0, $trader->getQuantity());
    }

}