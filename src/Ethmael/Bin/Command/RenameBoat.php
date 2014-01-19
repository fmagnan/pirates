<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class RenameBoat extends Command
{
    protected $game;

    public function __construct($game)
    {
        $this->game=$game;
        parent::__construct('boatname', 'boatname <new_name>: change pirate\'s boat\'s name');
    }

    public function run(Response $response, array $args=[])
    {
        if(!isset($args[0])) {
            $response->addLine('missing boat\'s name!');
            return;
        }
        $newName = $args[0];
        $pirate = $this->game->getPirate();
        $pirate->changeBoatName($newName);
        $response->addLine('You\'re boat is now known as ' . $pirate->showBoatName());
    }

}