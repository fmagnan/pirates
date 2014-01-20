<?php

namespace Ethmael\Domain;


class BoatTest extends \PHPUnit_Framework_TestCase {


    protected $settings;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->settings = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");
    }

    /**
     * @test
     * *
     */
    public function newBoatIsLevelOneBoat()
    {
        $clemenceau = new Boat($this->settings, "Arcadia");
        $this->assertEquals(1, $clemenceau->showLevel());
    }

    /**
     * @test
     *
     */
    public function newBoatHasHundredFreeSpace()
    {
        $clemenceau = new Boat($this->settings, "Titanic");
        $this->assertEquals(100, $clemenceau->showFreeSpace());

    }

    /**
     * @test
     *
     */
    public function newBoatHaveName()
    {
        $clemenceau = new Boat($this->settings,"Arcadia");
        $this->assertEquals("Arcadia", $clemenceau->showBoatName());

    }

    /**
     * @test
     *
     */
    public function newBoatHasEmptyStock()
    {
        $clemenceau = new Boat($this->settings,"toto");
        $this->assertEquals(0, $clemenceau->showStock());

    }

    /**
     * @test
     *
     */
    public function stockDestroyedIsReallyDestroyed()
    {
        $clemenceau = new Boat($this->settings,"Clemenceau");
        $clemenceau->addResource("Bois",12);
        $this->assertEquals(12, $clemenceau->showStock("Bois"));
        $clemenceau->destroyStock();
        $this->assertEquals(0, $clemenceau->showStock());
    }

    /**
     * @test
     *
     */
    public function upgradeBoatIncreaseLevelAndCapacity()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
        $clemenceau->upgradeBoatLevel();
        $this->assertEquals(2, $clemenceau->showLevel());
        $this->assertEquals(200, $clemenceau->showCapacity());
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Boat level can't
     */
    public function upgradeBoatLevelTenNotPossible()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
        $clemenceau->upgradeBoatLevel();
    }

    /**
     * @test
     *
     */
    public function downgradeBoatDecreaseLevelAndCapacity()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
        $clemenceau->upgradeBoatLevel();
        $this->assertEquals(2, $clemenceau->showLevel());
        $this->assertEquals(200, $clemenceau->showCapacity());
        $clemenceau->downgradeBoatLevel();
        $this->assertEquals(1, $clemenceau->showLevel());
        $this->assertEquals(100, $clemenceau->showCapacity());
    }

    /**
     * @test
     * @expectedException        \RangeException
     * @expectedExceptionMessage Boat level can't
     */
    public function downgradeBoatLevelOneNotPossible()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
        $clemenceau->downgradeBoatLevel();
    }

    /**
     * @test
     */
    public function addWoodIncreaseWoodStock()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
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
        $clemenceau = new Boat($this->settings,"Arcadia");
        $clemenceau->addResource("Bois",112);
    }

    /**
     * @test
     */
    public function addAsManyWoodAsPossible()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
        $clemenceau->addAsManyResourceAsPossible("Bois",112);
        $this->assertEquals(100, $clemenceau->showStock("Bois"));
    }

    /**
     * @test
     */
    public function getWoodDecreaseWoodStock()
    {
        $clemenceau = new Boat($this->settings,"Arcadia");
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
        $clemenceau = new Boat($this->settings,"toto");
        $clemenceau->addResource("Bois",50);
        $clemenceau->removeResource("Bois",51);
    }

    /**
     * @test
     */
    public function removeAsManyWoodAsPossible()
    {
        $clemenceau = new Boat($this->settings,"clemenceau");
        $clemenceau->addResource("Bois",50);
        $clemenceau->removeAsManyResourceAsPossible("Bois",112);
        $this->assertEquals(0, $clemenceau->showStock("Bois"));
    }

    /**
     * @test
     *
     */
    public function nameOfTheBoatCanBeChanged()
    {
        $clemenceau = new Boat($this->settings,"toto");
        $clemenceau->changeName("Arcadia");
        $this->assertEquals("Arcadia", $clemenceau->showBoatName());

    }

    /**
    * @test
    */
    public function theCompleteStockSumAllResources()
    {
        $clemenceau = new Boat($this->settings,"toto");
        $clemenceau->addResource("Bois",10);
        $clemenceau->addResource("Rubis",10);
        $this->assertEquals(20, $clemenceau->showStock());
        $this->assertEquals(80, $clemenceau->showFreeSpace());
    }


}
 