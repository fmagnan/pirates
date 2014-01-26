<?php

namespace Ethmael\Bin\Command;

use Ethmael\Bin\Colorizer;
use Ethmael\Domain\Cst;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

class Status extends Command
{
    protected $game;
    protected $player;

    public function __construct($player, $game)
    {
        $this->player = $player;
        $this->game = $game;
        parent::__construct('s', 'display current game status');
    }

    public function run(Request $request, Response $response)
    {
        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {
            return;
        }
        $boat = $pirate->getBoat();
        $resourceList = $boat->getResources();
        $place = $pirate->isLocatedIn();

        $colorizer = new Colorizer();
        $playerName = $colorizer->cyan($this->player->showName());
        $cityName = $colorizer->cyan($place->showCityName());
        $boatName = $colorizer->cyan($pirate->showBoatName());
        $gold = $colorizer->yellow($pirate->showGold());
        $capacity = $colorizer->lightRed($pirate->showBoatCapacity());
        $stock = $colorizer->lightRed($pirate->showStock());

        $lines = [
            $colorizer->horizontalRule(),
            'Tour de jeu n°' . $colorizer->yellow($this->game->showCurrentTurn()),
            sprintf('%s, votre bourse contient %s pièces d\'or !', $playerName, $gold),
            sprintf('Vous êtes à %s.', $cityName),
            sprintf('La capacité de votre bateau %s est de %s caisses.', $boatName, $capacity),
            sprintf('Vous transportez actuellement %s caisse(s).', $stock)
        ];

        $keys = array_keys($resourceList);
        foreach ($keys as $key) {
            if ($resourceList[$key] > 0) {
                $lines[] = ' - ' . $resourceList[$key] . ' caisse(s) de ' . $key . '.';
            }
        }

        $lines[] = PHP_EOL . sprintf('A %s, %s marchands sont ouverts : ', $cityName, $place->countOpenShop());

        $traders = $place->getAvailableTraders();
        foreach ($traders as $trader) {
            if ($trader->isOpen()) {
                $mask = '%s vend %s unités de %s au prix de %s po l\'unité';
                $traderName = $colorizer->green($trader->showName());
                $stock = $colorizer->lightRed($trader->showResourceAvailable());
                $resource = $colorizer->cyan($trader->showResource());
                $unitPrice = $colorizer->yellow($trader->showActualPrice());
                $lines[] = sprintf($mask, $traderName, $stock, $resource, $unitPrice);
            }
        }
        $lines[] = $colorizer->horizontalRule();

        $response->addMultiLines($lines);
    }

}