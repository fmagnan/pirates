<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Boat;
use Ethmael\Domain\Game;
use Ethmael\Domain\Cst;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

class CityList extends Command
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('city', 'display list of cities');
    }

    public function run(Request $resquest, Response $response)
    {
        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {return;}

        $map = $this->game->getMap();

        $visitedCities = $pirate->getVisitedCities();

        $response->addLine('Les villes disponibles sont : '.$map->showCityList());

        $response->addLine('Les villes visitées sont :');
        foreach ($visitedCities as $vcity){
            $message = "- ";
            $message = $message.$vcity->showCityName();
            $traders = $vcity->getAvailableTraders();

            $message = $message.' (';
            foreach ($traders as $trader) {
                if ($trader->isOpen()){
                    $message = $message.$trader->showResource().', ';
                }
            }
            $message = $message.')';

            $response->addLine($message);
        }
    }

}