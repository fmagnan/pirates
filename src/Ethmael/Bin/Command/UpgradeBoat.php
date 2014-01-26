<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;
use Ethmael\Domain\Game;

class UpgradeBoat extends Command
{

    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('upgradeboat', 'upgrade your boat to increase its capacity.');
    }

    public function run(Request $request, Response $response)
    {
        $pirate = $this->game->getPirate();
        $city = $pirate->isLocatedIn();
        $city->upgradeBoat($pirate);
        $mask = 'Bravo ! La nouvelle capacité de votre bateau est de %d caisses.';
        $response->addLine(sprintf($mask, $pirate->showBoatCapacity()));
    }

}