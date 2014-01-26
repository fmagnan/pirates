<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;
use Ethmael\Domain\Game;

class Travel extends OneArgumentCommand
{

    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('travel', 'travel to another city, a new turn begins.');
    }

    public function run(Request $request, Response $response)
    {
        $cityName = $this->getArgument($request, $response);

        $pirate = $this->game->getPirate();

        $map = $this->game->getMap();
        $destination = $map->getCityWithName($cityName);
        $pirate->setLocation($destination);
        $this->game->newTurn($response);
    }

}