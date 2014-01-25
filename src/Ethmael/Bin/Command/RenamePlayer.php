<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Player;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

class RenamePlayer extends OneArgumentCommand
{
    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
        parent::__construct('rename', 'rename <new_name>: change player\'s name');
    }

    public function run(Request $request, Response $response)
    {
        $newName = $this->getArgument($request, $response);
        $this->player->rename($newName);
        $response->addLine('You are now known as ' . $newName);
    }

}