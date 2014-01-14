<?php

namespace Ethmael\Domain;
use Ethmael\Utils\Config;

class CityTest extends \PHPUnit_Framework_TestCase
{

    protected $config;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->config = Config::loadConfigFile($projectRootPath . "data.yml");
    }

    /**
     * @test
     */
    public function newCityHasDefaultName()
    {
        $city = new City($this->config);
        $this->assertEquals("defaultName",$city->showCityName());
    }

    /**
     * @test
     */
    public function newCityHasDefaultDescription()
    {
        $city = new City($this->config);
        $this->assertEquals("Une ville quelconque",$city->showCityDescription());
    }

    public function descriptionOfCityCanBeChanged()
    {
        $city = new City($this->config);
        $city->newCityDescription("Wow!");
        $this->assertEquals("Wow!",$city->showCityDescription());
    }

    /**
     * @test
     */
    public function cityCanHaveName()
    {
        $city = new City($this->config);
        $city->newCityName("Saigon");
        $this->assertEquals("Saigon",$city->showCityName());
    }

    /**
     * @test
     */
    public function cityCanChangeHerName()
    {
        $city = new City($this->config);
        $city->newCityName("Puerto Rico");
        $this->assertEquals("Puerto Rico",$city->showCityName());
    }

    /**
     * @test
     */

    public function cityCanDealOnlyRes1OnlyIfTraderExist()
    {
        // Get the list of available resources
        $resourceList = $this->config["ResourceName"];

        $city = new City($this->config);
        $trader1 = new Trader($this->config);
        $trader1->initTrader($resourceList[0],10,10);
        $city->addShop($trader1);

        $this->assertFalse($city->canDealWith($resourceList[1]));
    }

    /**
     * @test
     */
    public function cityWithResource0CanDealWithResource0()
    {
        // Get the list of available resources
        $resourceList = $this->config["ResourceName"];

        $city = new City($this->config);
        $wood = new Trader($this->config);
        $wood->initTrader($resourceList[0], 10);
        $city->addShop($wood);
        $this->assertTrue($city->canDealWith($resourceList[0]));
    }

    /**
     * @test
     */
    public function emptyCityHasNoTraderAvailable()
    {
        $city = new City($this->config);
        $this->assertEmpty($city->getAvailableTraders());
    }


}