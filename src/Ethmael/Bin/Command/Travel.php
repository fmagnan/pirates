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
        //@todo gerer l'exception qui est levee quand la ville n'existe pas
        $destination = $this->game->getCityWithName($cityName);
        //@todo gerer l'exception qui est levee quand la ville est la même que la current
        $pirate->setLocation($destination);
        //@todo gerer l'exception qui est levee quand la partie est finie
        $this->game->newTurn();
    }

}