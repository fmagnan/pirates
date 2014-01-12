<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Player;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class RenamePlayer extends Command
{
    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
        parent::__construct('rename', 'rename <new_name>: change player\'s name');
    }

    public function run(Response $response, array $args = [])
    {
        if (!isset($args[0])) {
            $response->addLine('missing player\'s name!');
            return;
        }
        $newName = $args[0];
        $this->player->rename($newName);
        $response->addLine('You are now known as ' . $newName);
    }

}