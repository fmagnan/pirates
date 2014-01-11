<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class RenamePlayer extends Command
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, 'rename', 'rename <new_name>: change player\'s name');
    }

    public function run(Response $response, array $args=[])
    {
        if(!isset($args[0])) {
            $response->addLine('missing player\'s name!');
            return;
        }
        $newName = $args[0];
        $this->registry->getPlayer()->rename($newName);
        $response->addLine('You are now known as ' . $newName);
    }

}