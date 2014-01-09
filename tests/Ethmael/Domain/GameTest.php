<?php

namespace Ethmael\Domain;

class GameTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function newGameHasNoCity()
    {
        $game = new Game();
        $this->assertEquals(0,$game->countCity());
    }

    /**
     * @test
     */
    public function GameHasTwoCitiesAfterAddingTwoCities()
    {
        $ofThrones = new Game();

        $saigon = new City("Saigon");
        $wood = new Trader(Trader::WOOD, 10);
        $saigon->addTrader($wood);
        $ofThrones->addCity($saigon);

        $PuertoRico = new City("Puerto Rico");
        $wood = new Trader(Trader::WOOD, 10);
        $PuertoRico->addTrader($wood);
        $ofThrones->addCity($PuertoRico);

        $this->assertEquals(2,$ofThrones->countCity());
    }

    /**
     * @test
     */
    public function GameHasOnePirateAfterAddingOnePirate()
    {
        $ofThrones = new Game();

        $pirate = new Pirate();
        $ofThrones->addPirate($pirate);

        $newPirate = $ofThrones->getPirate();
        $this->assertEquals($pirate,$newPirate);
    }

}