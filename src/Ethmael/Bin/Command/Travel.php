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
        parent::__construct('travel', 'travel <newCity> : travel to another city. New game turn.');
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