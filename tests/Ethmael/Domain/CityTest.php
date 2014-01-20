<?php

namespace Ethmael\Domain;
use Ethmael\Utils\Config;

class CityTest extends \PHPUnit_Framework_TestCase
{

    protected $settings;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->settings = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");
    }

    /**
     * @test
     */
    public function newCityHasDefaultNameAndDesc()
    {
        $city = new City($this->settings);
        $this->assertEquals("montpellier",$city->showCityName());
        $this->assertEquals("Wow",$city->showCityDescription());
    }

    /**
     * @test
     */
    public function newCityCanHaveNewNameAndDesc()
    {
        $city = new City($this->settings,"Paris","Berk");
        $this->assertEquals("Paris",$city->showCityName());
        $this->assertEquals("Berk",$city->showCityDescription());
    }

    /**
     * @test
     * TODO : faire les tests de City->InitCity()
     */
    public function cityInit()
    {
        $this->assertEquals("toDo","toDo");
    }

    /**
     * @test
     */
    public function newCityHasNoTraderAvailable()
    {
        $city = new City($this->settings);
        $this->assertEmpty($city->getAvailableTraders());
    }

    /**
     * @test
     * @expectedException        \Exception
     * @expectedExceptionMessage Trader does not exist
     */
    public function unknownTraderNotAvailable()
    {
        $city = new City($this->settings);
        $trader1 = new Trader($this->settings);
        $trader1->initTrader("john","coucou","Bois",10,10);
        $city->addShop($trader1);
        $city->getTraderByName("Mitch");
    }

    /**
     * @test
     */
    public function addingShopMakeTraderAvailable()
    {
        $city = new City($this->settings);
        $trader1 = new Trader($this->settings);
        $trader1->initTrader("john","coucou","Bois",10,10);
        $city->addShop($trader1);
        $city->getTraderByName("john");
    }

    /**
     * @test
     */
    public function shopOpenedAreReallyOpened()
    {
        $city = new City($this->settings);
        $trader1 = new Trader($this->settings);
        $trader1->initTrader("john","coucou","Bois",10,10);
        $city->addShop($trader1);
        $trader2 = new Trader($this->settings);
        $trader2->initTrader("bob","coucou","Rubis",10,10);
        $city->addShop($trader2);
        $this->assertEquals(0,$city->countOpenShop());

        $city->openShop("Bois");
        $this->assertEquals(1,$city->countOpenShop());

        $city->openShop("Rubis");
        $this->assertEquals(2,$city->countOpenShop());

        $city->closeShop("Bois");
        $this->assertEquals(1,$city->countOpenShop());
    }

    /**
     * @test
     */

    public function cityCanDealWoodOnlyIfWoodTraderAvailable()
    {
        $city = new City($this->settings);
        $trader1 = new Trader($this->settings);
        $trader1->initTrader("john","coucou","Bois",10,10);
        $city->addShop($trader1);
        $this->assertTrue($city->canDealWith("Bois"));
        $this->assertFalse($city->canDealWith("Rubis"));
    }

    /**
     * @test
     */

    public function cityUpgradeABoat()
    {
        $pirate = new Pirate($this->settings);
        $pirate->giveGold(4000);
        $pirate->buyNewBoat("Titanic");

        $this->assertEquals(100,$pirate->showBoatCapacity());

        $city = new City($this->settings);
        $city->upgradeBoat($pirate);

        $this->assertEquals(200,$pirate->showBoatCapacity());
    }

    /**
     * @test
     */
    public function descriptionOfCityCanBeChanged()
    {
        $city = new City($this->settings);
        $city->changeCityDescription("WowWow");
        $this->assertEquals("WowWow",$city->showCityDescription());
    }

    /**
     * @test
     */
    public function nameOfCityCanBeChanged()
    {
        $city = new City($this->settings);
        $city->changeCityName("Puerto Rico");
        $this->assertEquals("Puerto Rico",$city->showCityName());
    }
}