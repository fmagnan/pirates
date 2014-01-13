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
        $response->addLine('Player name: ' . $this->player->showName());

        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {
            return;
        }
        $boat = $pirate->getBoat();
        $place = $pirate->isLocatedIn();

        $response->addLine('Pirate Boat name: ' . $pirate->boatName());
        $response->addLine('Pirate Boat capacity: ' . $boat->getCapacity());
        $response->addLine('Pirate Boat WOOD Stock: ' . $boat->getStock("Bois"));
        $response->addLine('Pirate Boat JEWELS Stock: ' . $boat->getStock("Bois"));
        $response->addLine('Current City name: ' . $place->name());
        $response->addLine('Current City description: ' . $place->description());
    }

}