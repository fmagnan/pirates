<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class BuyResourceToTrader extends Command
{
    protected $core;
    protected $game;

    public function __construct($core, $game)
    {
        $this->core = $core;
        $this->game = $game;
        parent::__construct('buy', 'buy <trader> <quantity>: change player\'s name');
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

        //@todo gerer l'exception qui est levee quand on ne peut pas acheter
        $trader = $this->core->buyResourcetoTrader($this->game, $traderName, $quantity);
        $response->addLine(sprintf('You bought %d resources of type n°%s to %s', $quantity, $trader->getType(), $traderName));
        $response->addLine(sprintf('%s has %s unities left', $traderName, $trader->getQuantity()));
    }

}