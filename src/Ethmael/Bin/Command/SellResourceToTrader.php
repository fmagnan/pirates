<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class SellResourceToTrader extends Command
{
    protected $core;
    protected $game;

    public function __construct($core, $game)
    {
        $this->core = $core;
        $this->game = $game;
        parent::__construct('sell', 'sell <trader> <quantity>: sell resource to a Trader');
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

        try{
            $trader = $this->core->sellResourcetoTrader($this->game, $traderName, $quantity);
            $response->addLine(sprintf('Vous avez vendu %d caisses de %s à %s', $quantity, $trader->showResource(), $traderName));
            $response->addLine(sprintf('%s a maintenant %s caisses.', $traderName, $trader->showResourceAvailable()));
        } catch (\RangeException $e) {
            $response->addLine($e->getMessage());
        }
    }

}