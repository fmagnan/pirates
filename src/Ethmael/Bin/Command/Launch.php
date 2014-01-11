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

    public function run(Response $response)
    {
        $this->registry->initCities();
        $this->registry->initPirate();

        $game = $this->registry->getGame();
        $player = $this->registry->getPlayer();
        $pirate = $game->getPirate();

        $response->addLine('Re-Bonjour jeune pirate.', $player->showName());
        $response->addLine('Vous êtes le Capitaine du merveilleux navire ' . $pirate->boatName());
        $response->addLine(sprintf("Votre bourse contient %d pièces d'or.", $pirate->countGold()));
        $response->addLine('Vous vous trouvez dans la ville de :');
        $response->addLine($pirate->isLocatedIn()->name());
        $response->addLine($pirate->isLocatedIn()->description());
    }

}