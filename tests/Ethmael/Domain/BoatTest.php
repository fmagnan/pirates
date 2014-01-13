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
        $this->config = Config::loadConfigFile($projectRootPath . "data.yml");
    }

    /**
     * @test
     * *
     */
    public function newBoatIsLevelOneBoat()
    {
        $clemenceau = new Boat($this->config);
        $this->assertEquals(1, $clemenceau->getLevel());

    }

    /**
     * @test
     *
     */
    public function newBoatHasEmptyStock()
    {
        $clemenceau = new Boat($this->config);
        $this->assertEquals(0, $clemenceau->getStock());

    }

    /**
     * @test
     *
     name is random. Test to be deleted
    public function newBoatHasName()
    {
        $clemenceau = new Boat($this->config);
        $this->assertEquals("default", $clemenceau->getName());

    }*/

    /**
     * @test
     *
     */
    public function nameOfTheBoatCanBeChanged()
    {
        $clemenceau = new Boat($this->config);
        $clemenceau->changeName("Arcadia");
        $this->assertEquals("Arcadia", $clemenceau->getName());

    }

    /**
     * @test
     *
     */
    public function newBoatHasHundredFreeSpace()
    {
        $clemenceau = new Boat($this->config);
        $this->assertEquals(100, $clemenceau->freeSpace());

    }

    /**
     * @test
     */
    public function addWoodIncreaseWoodStock()
    {
        $clemenceau = new Boat($this->config);
        $clemenceau->addResource("Bois",12);
        $this->assertEquals(12, $clemenceau->getStock("Bois"));

    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough free
     */
    public function addMoreResourceThanBoatCapacity()
    {
        $clemenceau = new Boat($this->config);
        $clemenceau->addResource("Bois",112);
    }

    /**
     * @test
     */
    public function getJewelsDecreaseJewelsStock()
    {
        $clemenceau = new Boat($this->config);
        $clemenceau->addResource("Bois",50);
        $clemenceau->removeResource("Bois",38);
        $this->assertEquals(12, $clemenceau->getStock("Bois"));

    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough Resource
     */
    public function getMoreJewelsThanBoatStock()
    {
        $clemenceau = new Boat($this->config);
        $clemenceau->addResource("Bois",50);
        $clemenceau->removeResource("Bois",51);
    }


    /**
     * @test
     *
     */
    public function upgradeBoatIncreaseLevelAndCapacity()
    {
        $clemenceau = new Boat($this->config);
        $clemenceau->upgradeBoatLevel();
        $this->assertEquals(2, $clemenceau->getLevel());
        $this->assertEquals(200, $clemenceau->getCapacity());

    }





}
 