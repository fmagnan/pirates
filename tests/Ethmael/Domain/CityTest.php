<?php

namespace Ethmael\Domain;

class CityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function newCityHasDefaultName()
    {
        $city = new City();
        $this->assertEquals("defaultName",$city->Name());
    }

    /**
     * @test
     */
    public function newCityHasDefaultDescription()
    {
        $city = new City();
        $this->assertEquals("une ville quelconque",$city->description());
    }

    public function descriptionOfCityCanBeChanged()
    {
        $city = new City();
        $city->newDescription("Wow!");
        $this->assertEquals("Wow!",$city->description());
    }

    /**
     * @test
     */
    public function cityCanHaveName()
    {
        $city = new City("Saigon");
        $this->assertEquals("Saigon",$city->Name());
    }

    /**
     * @test
     */
    public function cityCanChangeHerName()
    {
        $city = new City("Saigon");
        $city->newName("Puerto Rico");
        $this->assertEquals("Puerto Rico",$city->Name());
    }

    /**
     * @test
     */
    public function cityWithWoodDoesNotDealWithJewels()
    {

        $city = new City();
        $wood = new Trader(Cst::WOOD, 10);
        $city->addTrader($wood);
        $jewels = new Trader(Cst::JEWELS, 10);
        $this->assertFalse($city->canDealWith($jewels));
    }

    /**
     * @test
     */
    public function cityWithWoodCanDealWithWood()
    {
        $city = new City();
        $wood = new Trader(Cst::WOOD, 10);
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