<?php
/**
 * Created by PhpStorm.
 * User: Willy
 * Date: 05/01/14
 * Time: 13:49
 */

namespace Ethmael\Domain;

use Ethmael\Utils\Config;

class BoatTest extends \PHPUnit_Framework_TestCase {


    protected $config;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->config = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");
    }

    /**
     * @test
     * *
     */
    public function newBoatIsLevelOneBoat()
    {
        $clemenceau = new Boat($this->config, "toto");
        $this->assertEquals(1, $clemenceau->showLevel());
    }


    /**
     * @test
     *
     */
    public function newBoatHasEmptyStock()
    {
        $clemenceau = new Boat($this->config,"toto");
        $this->assertEquals(0, $clemenceau->showStock());

    }

    /**
     * @test
     *
     */
    public function nameOfTheBoatCanBeChanged()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->changeName("Arcadia");
        $this->assertEquals("Arcadia", $clemenceau->showBoatName());

    }

    /**
     * @test
     *
     */
    public function newBoatHasHundredFreeSpace()
    {
        $clemenceau = new Boat($this->config,"toto");
        $this->assertEquals(100, $clemenceau->showFreeSpace());

    }

    /**
     * @test
     */
    public function addWoodIncreaseWoodStock()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",12);
        $this->assertEquals(12, $clemenceau->showStock("Bois"));

    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough free
     */
    public function addMoreResourceThanBoatCapacity()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",112);
    }

    /**
     * @test
     */
    public function getWoodDecreaseWoodStock()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",50);
        $clemenceau->removeResource("Bois",38);
        $this->assertEquals(12, $clemenceau->showStock("Bois"));

    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough Resource
     */
    public function getMoreWoodThanBoatStock()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",50);
        $clemenceau->removeResource("Bois",51);
    }


    /**
     * @test
     *
     */
    public function upgradeBoatIncreaseLevelAndCapacity()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->upgradeBoatLevel();
        $this->assertEquals(2, $clemenceau->showLevel());
        $this->assertEquals(200, $clemenceau->showCapacity());

    }

    /**
     * @test
     *
     */
    public function downgradeBoatDecreaseLevelAndCapacity()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->upgradeBoatLevel();
        $this->assertEquals(2, $clemenceau->showLevel());
        $this->assertEquals(200, $clemenceau->showCapacity());

        $clemenceau->downgradeBoatLevel();
        $this->assertEquals(1, $clemenceau->showLevel());
        $this->assertEquals(100, $clemenceau->showCapacity());

    }

    /**
 * @test
 *
 */
    public function theCompleteStockSumAllResources()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",10);
        $clemenceau->addResource("Rubis",10);
        $this->assertEquals(20, $clemenceau->showStock());

    }

    /**
     * @test
     *
     */
    public function addingTooMuchResourcesGiveAFullBoat()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",90);
        $clemenceau->addAsManyResourceAsPossible("Rubis",20);
        $this->assertEquals(100, $clemenceau->showStock());
        $this->assertEquals(10, $clemenceau->showStock("Rubis"));

    }

    /**
     * @test
     *
     */
    public function destroyStockEmptyTheBoat()
    {
        $clemenceau = new Boat($this->config,"toto");
        $clemenceau->addResource("Bois",10);
        $clemenceau->addResource("Rubis",10);
        $clemenceau->destroyStock();
        $this->assertEquals(0, $clemenceau->showStock());

    }

}
 