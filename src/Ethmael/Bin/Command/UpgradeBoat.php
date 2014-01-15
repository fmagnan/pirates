<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class UpgradeBoat extends Command
{
    protected $core;
    protected $game;

    public function __construct($core, $game)
    {
        $this->core = $core;
        $this->game = $game;
        parent::__construct('upgradeboat', 'upgradeboat : upgrade your boat to increase capacity.');
    }

    public function run(Response $response, array $args = [])
    {
        try {
            $pirate = $this->game->getPirate();
            $city = $pirate->isLocatedIn();
            $city->upgradeBoat($pirate);
            $response->addLine(sprintf('Bravo ! La nouvelle capacité de votre bateau est de %d caisses.', $pirate->showBoatCapacity()));
        } catch (\RangeException $e) {
            $response->addLine($e->getMessage());
        }
    }

}