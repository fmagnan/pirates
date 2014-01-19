<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;
use Ethmael\Domain\Game;

class Travel extends Command
{

    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('travel', 'travel <newCity> : travel to another city. New game turn.');
    }

    public function run(Response $response, array $args = [])
    {
        if (!isset($args[0])) {
            $response->addLine('missing city!');
            return;
        }

        $cityName = $args[0];

        $pirate = $this->game->getPirate();

        try {
            $map = $this->game->getMap();
            $destination = $map->getCityWithName($cityName);
            $pirate->setLocation($destination);
            $this->game->newTurn($response);
        } catch (\Exception $e) {
            $response->addLine($e->getMessage());
        }
    }

}