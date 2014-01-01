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
        $wood = new Resource(Resource::WOOD);
        $city->addResource($wood);
        $jewels = new Resource(Resource::JEWELS);
        $this->assertFalse($city->canDealWith($jewels));
    }

    /**
     * @test
     */
    public function cityWithWoodCanDealWithWood()
    {
        $city = new City();
        $wood = new Resource(Resource::WOOD);
        $city->addResource($wood);
        $this->assertTrue($city->canDealWith($wood));
    }

    /**
     * @test
     */
    public function emptyCityHasNoResourceAvailable()
    {
        $city = new City();
        $this->assertEmpty($city->getAvailableResources());
    }


}