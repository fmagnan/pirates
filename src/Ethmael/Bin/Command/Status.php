<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Boat;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class Status extends Command
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, 'status', 'status: display current game status');
    }

    public function run(Response $response)
    {
        $player = $this->registry->getPlayer();
        $response->addLine('Player name: ' . $player->showName());

        $game = $this->registry->getGame();
        $pirate = $game->getPirate();
        if (is_null($pirate)) {
            return;
        }
        $boat = $pirate->getBoat();
        $place = $pirate->isLocatedIn();

        $response->addLine('Pirate Boat name: ' . $pirate->boatName());
        $response->addLine('Pirate Boat capacity: ' . $boat->getCapacity());
        $response->addLine('Pirate Boat WOOD Stock: ' . $boat->getStock(Boat::WOOD));
        $response->addLine('Pirate Boat JEWELS Stock: ' . $boat->getStock(Boat::JEWELS));
        $response->addLine('Current City name: ' . $place->name());
        $response->addLine('Current City description: ' . $place->description());
    }

}