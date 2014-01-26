<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

class RenameBoat extends OneArgumentCommand
{
    protected $game;

    public function __construct($game)
    {
        $this->game=$game;
        parent::__construct('boatname', 'change pirate\'s boat\'s name to <new_name>');
    }

    public function run(Request $request, Response $response)
    {
        $newName = $this->getArgument($request, $response);
        $pirate = $this->game->getPirate();
        $pirate->changeBoatName($newName);
        $response->addLine('You\'re boat is now known as ' . $pirate->showBoatName());
    }

}