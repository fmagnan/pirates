<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class Travel extends Command
{
    protected $core;
    protected $game;

    public function __construct($core, $game)
    {
        $this->core = $core;
        $this->game = $game;
        parent::__construct('travel', 'travel <newCity> : travel to another city. New game turn.');
    }

    public function run(Response $response, array $args = [])
    {
        if (!isset($args[0])) {
            $response->addLine('missing city!');
            return;
        }

        $cityName = $args[0];



        $pirate = $this->game->getPirate();

        try {
            $destination = $this->game->getCityWithName($cityName);
            $pirate->setLocation($destination);
            $this->game->newTurn();
        } catch (\Exception $e) {
            $response->addLine($e->getMessage());
        }
    }

}