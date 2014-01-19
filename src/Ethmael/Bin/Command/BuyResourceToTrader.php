<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;
use Ethmael\Domain\Game;

class BuyResourceToTrader extends Command
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('buy', 'buy <trader> <quantity>: buy resource to a Trader');
    }

    public function run(Response $response, array $args = [])
    {
        if (!isset($args[0])) {
            $response->addLine('missing trader!');
            return;
        }

        if (!isset($args[1])) {
            $response->addLine('missing quantity!');
            return;
        }
        $traderName = $args[0];
        $quantity = $args[1];

        try {

            $pirate = $this->game->getPirate();
            $city = $pirate->isLocatedIn();
            $trader = $city->getTraderByName($traderName);
            $trader->sell($pirate, $quantity);
            $response->addLine(sprintf('Vous avez acheté %d caisses de %s à %s.', $quantity, $trader->showResource(), $traderName));
            $response->addLine(sprintf('Il reste à %s %s caisses.', $traderName, $trader->showResourceAvailable()));
        } catch (\RangeException $e) {
            $response->addLine($e->getMessage());
        }
    }

}