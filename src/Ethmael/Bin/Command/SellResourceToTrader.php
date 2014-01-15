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

        //@todo gerer l'exception qui est levee quand on n'a pas assez de resource pour les vendre au marchand
        $trader = $this->core->sellResourcetoTrader($this->game, $traderName, $quantity);
        $response->addLine(sprintf('You sold %d resources of type n°%s to %s', $quantity, $trader->showResource(), $traderName));
        $response->addLine(sprintf('%s has %s unities left', $traderName, $trader->showResourceAvailable()));
    }

}