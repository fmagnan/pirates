<?php
/**
 * Created by PhpStorm.
 * User: Willy
 * Date: 05/01/14
 * Time: 13:49
 */

namespace Ethmael\Domain;


class BoatTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     * *
     */
    public function newBoatIsLevelOneBoat()
    {
        $clemenceau = new Boat();
        $this->assertEquals(1, $clemenceau->getLevel());

    }

    /**
     * @test
     *
     */
    public function newBoatHasEmptyStock()
    {
        $clemenceau = new Boat();
        $this->assertEquals(0, $clemenceau->getStock());

    }

    /**
     * @test
     *
     */
    public function newBoatHasName()
    {
        $clemenceau = new Boat("Clemenceau");
        $this->assertEquals("Clemenceau", $clemenceau->getName());

    }

    /**
     * @test
     *
     */
    public function nameOfTheBoatCanBeChanged()
    {
        $clemenceau = new Boat("Clemenceau");
        $clemenceau->changeName("Arcadia");
        $this->assertEquals("Arcadia", $clemenceau->getName());

    }

    /**
     * @test
     *
     */
    public function newBoatHasHundredFreeSpace()
    {
        $clemenceau = new Boat();
        $this->assertEquals(100, $clemenceau->freeSpace());

    }

    /**
     * @test
     */
    public function addWoodIncreaseWoodStock()
    {
        $clemenceau = new Boat();
        $clemenceau->addResource(Cst::WOOD,12);
        $this->assertEquals(12, $clemenceau->getStock(Cst::WOOD));

    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough free
     */
    public function addMoreResourceThanBoatCapacity()
    {
        $clemenceau = new Boat();
        $clemenceau->addResource(Cst::WOOD,112);
    }

    /**
     * @test
     */
    public function getJewelsDecreaseJewelsStock()
    {
        $clemenceau = new Boat();
        $clemenceau->addResource(Cst::JEWELS,50);
        $clemenceau->removeResource(Cst::JEWELS,38);
        $this->assertEquals(12, $clemenceau->getStock(Cst::JEWELS));

    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage not enough Resource
     */
    public function getMoreJewelsThanBoatStock()
    {
        $clemenceau = new Boat();
        $clemenceau->addResource(Cst::JEWELS,50);
        $clemenceau->removeResource(Cst::JEWELS,51);
    }


    /**
     * @test
     *
     */
    public function upgradeBoatIncreaseLevelAndCapacity()
    {
        $clemenceau = new Boat();
        $clemenceau->upgradeBoatLevel();
        $this->assertEquals(2, $clemenceau->getLevel());
        $this->assertEquals(200, $clemenceau->getCapacity());

    }





}
 