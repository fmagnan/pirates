<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Boat;
use Ethmael\Domain\Game;
use Ethmael\Domain\Cst;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class CityList extends Command
{
    protected $game;
    protected $player;

    public function __construct($player, $game)
    {
        $this->player = $player;
        $this->game = $game;
        parent::__construct('city', 'city: display list of cities');
    }

    public function run(Response $response, array $args=[])
    {
        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {return;}

        $cities = $this->game->getCities();
        $visitedCities = $pirate->getVisitedCities();

        $response->addLine('Les villes disponibles sont : '.$this->game->showCityList());

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