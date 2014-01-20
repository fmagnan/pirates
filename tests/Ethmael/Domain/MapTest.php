<?php

namespace Ethmael\Domain;


class MapTest extends \PHPUnit_Framework_TestCase {


    protected $settings;

    public function setUp()
    {
        $projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR;
        $projectRootPath = $projectRootPath . "config". DIRECTORY_SEPARATOR;
        $this->settings = new \Ethmael\Domain\Settings($projectRootPath . "data.yml");
    }

    /**
     * @test
     * TODO
     */
    public function newBoatIsLevelOneBoat()
    {
        $this->assertEquals(true, true);
    }




}
 