<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class Launch extends Command
{
    protected $core;
    protected $game;
    protected $player;

    public function __construct($core, $game, $player)
    {
        $this->core = $core;
        $this->game = $game;
        $this->player = $player;
        parent::__construct('launch', 'launch: launch a new game');
    }

    public function run(Response $response, array $args = [])
    {
        $this->core->initCities($this->game);
        $pirate = $this->core->initPirate($this->game);

        $response->addLine('Re-Bonjour jeune pirate.', $this->player->showName());
        $response->addLine('Vous êtes le Capitaine du merveilleux navire ' . $pirate->boatName());
        $response->addLine(sprintf("Votre bourse contient %d pièces d'or.", $pirate->countGold()));
        $response->addLine('Vous vous trouvez dans la ville de :');
        $response->addLine($pirate->isLocatedIn()->name());
        $response->addLine($pirate->isLocatedIn()->description());
    }

}