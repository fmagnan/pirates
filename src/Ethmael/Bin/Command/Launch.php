<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class Launch extends Command
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, 'launch', 'launch: launch a new game');
    }

    public function run(Response $response, array $args=[])
    {
        $core = $this->registry->getEntity('core');
        $game = $this->registry->getEntity('game');
        $player = $this->registry->getEntity('player');
        $core->initCities($game);
        $pirate = $core->initPirate($game);

        $response->addLine('Re-Bonjour jeune pirate.', $player->showName());
        $response->addLine('Vous êtes le Capitaine du merveilleux navire ' . $pirate->boatName());
        $response->addLine(sprintf("Votre bourse contient %d pièces d'or.", $pirate->countGold()));
        $response->addLine('Vous vous trouvez dans la ville de :');
        $response->addLine($pirate->isLocatedIn()->name());
        $response->addLine($pirate->isLocatedIn()->description());
    }

}