<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;
use Ethmael\Domain\Game;

class VisitBoat extends Command
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
        parent::__construct('visitboat', 'visitboat: visit your own boat');
    }

    public function run(Response $response, array $args=[])
    {
        $pirate = $this->game->getPirate();

        $lines = [
            "Vous avez beau chercher, il n'y a aucune bière dans votre cabine !",
            "Attendant que votre second vous serve un bon vieux rhum, vous jetez un coup d'oeil sur l'état de votre raffiot.",
            sprintf("Ce bon vieil %s et ses %d caisses entreposables en cale.", $pirate->showBoatName(), $pirate->showBoatCapacity())
        ];

        if ($pirate->showBoatStock() == 0) {
            $lines[] = "Le problème, c'est que les cales sont vides ! Il va falloir remplir tout ça.";
        } else {
            $lines[] = "Pour l'instant, nous avons en cale :";
            $lines[] = sprintf("- %d caisses de bois.", $pirate->showBoatStock());
            $lines[] = sprintf("- %d coffres de joyaux.", $pirate->showBoatStock());
        }

        $response->addMultiLines($lines);
    }

}