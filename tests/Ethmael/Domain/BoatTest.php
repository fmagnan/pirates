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
     */
    public function newBoatIsLevelOneBoat()
    {
        $clemenceau = new Boat();
        $this->assertEquals(1, $clemenceau->getLevel());

    }

}
 