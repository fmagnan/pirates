<?php

namespace Ethmael\Domain;

class CityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function cityWithWoodDoesNotDealWithJewels()
    {
        $city = new City();
        $wood = new Trader(Trader::WOOD);
        $city->addTrader($wood);
        $jewels = new Trader(Trader::JEWELS);
        $this->assertFalse($city->canDealWith($jewels));
    }

    /**
     * @test
     */
    public function cityWithWoodCanDealWithWood()
    {
        $city = new City();
        $wood = new Trader(Trader::WOOD);
        $city->addTrader($wood);
        $this->assertTrue($city->canDealWith($wood));
    }

    /**
     * @test
     */
    public function emptyCityHasNoTraderAvailable()
    {
        $city = new City();
        $this->assertEmpty($city->getAvailableTraders());
    }


}