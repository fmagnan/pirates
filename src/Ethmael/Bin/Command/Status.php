<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Boat;
use Ethmael\Domain\Cst;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class Status extends Command
{
    protected $game;
    protected $player;

    public function __construct($player, $game)
    {
        $this->player = $player;
        $this->game = $game;
        parent::__construct('status', 'status: display current game status');
    }

    public function run(Response $response, array $args=[])
    {
        $response->addLine('-----PLAYER---------------------');
        $response->addLine('Name: ' . $this->player->showName());
        $response->addLine('--------------------------------');
        $response->addLine('');
        $response->addLine('-----PIRATE---------------------');
        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {
            return;
        }
        $boat = $pirate->getBoat();
        $place = $pirate->isLocatedIn();
        $response->addLine('Boat name     : ' . $pirate->showBoatName());
        $response->addLine('Boat capacity : ' . $boat->showCapacity());
        $response->addLine('Location      : ' . $place->showCityName());
        //$response->addLine('Current City description: ' . $place->showCityDescription());
        $response->addLine('--------------------------------');
        $response->addLine('');
        $response->addLine('-----CITIES---------------------');
        $cities = $this->game->getCities();
        foreach ($cities as $city){
            $response->addLine('- '. $city->showCityName(). ' : '.$city->showCityDescription());
            $traders = $city->getAvailableTraders();
            foreach ($traders as $trader){
                $response->addLine('--- Trader : '. $trader->showTraderName().' : '.$trader->showWelcomeMessage());
                $response->addLine('    '.$trader->showResourceAvailable().' '. $trader->showResource().  ' available at '.$trader->showPrice().' golds each.');
            }
            $response->addLine('');
        }
        $response->addLine('--------------------------------');
    }

}