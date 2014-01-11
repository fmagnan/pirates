<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class BuyResourceToTrader extends Command
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, 'buy', 'buy <trader> <quantity>: change player\'s name');
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

        $trader = $this->registry->buyResourcetoTrader($traderName, $quantity);
        $response->addLine(sprintf('You bought resource %d n°%s to %s', $quantity, $trader->getType(), $traderName));
        $response->addLine(sprintf('%s has %s unities left', $traderName, $trader->getQuantity()));
    }

}