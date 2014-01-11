<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class RenameBoat extends Command
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, 'boatname', 'boatname <new_name>: change pirate\'s boat\'s name');
    }

    public function run(Response $response, array $args=[])
    {
        if(!isset($args[0])) {
            $response->addLine('missing boat\'s name!');
            return;
        }
        $newName = $args[0];
        $this->registry->getGame()->getPirate()->getBoat()->changeName($newName);
        $response->addLine('You\'re boat is now known as ' . $newName);
    }

}