<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;
use Ethmael\Domain\Game;


class SellResourceToTrader extends TwoArgumentsCommand
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('sell', 'sell to a <trader> a certain <quantity> of resource');
    }

    public function run(Request $request, Response $response)
    {
        $arguments = $this->getArguments($request, $response);
        $traderName = $arguments[0];
        $quantity = $arguments[1];

        $pirate = $this->game->getPirate();
        $city = $pirate->isLocatedIn();
        $trader = $city->getTraderByName($traderName);
        $trader->buy($pirate, $quantity);
        $response->addLine(
            sprintf('Vous avez vendu %d caisses de %s à %s', $quantity, $trader->showResource(), $traderName)
        );
        $response->addLine(sprintf('%s a maintenant %s caisses.', $traderName, $trader->showResourceAvailable()));
    }

}