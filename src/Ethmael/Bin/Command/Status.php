<?php

namespace Ethmael\Bin\Command;

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
        parent::__construct('s', 's: display current game status');
    }

    public function run(Request $request, Response $response)
    {
        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {return;}
        $boat = $pirate->getBoat();
        $resourceList = $boat->getResources();
        $place = $pirate->isLocatedIn();

        $response->addLine('--------------------------------');
        $response->addLine('Tour de jeu -> ' . $this->game->showCurrentTurn());
        $response->addLine($this->player->showName().', votre bourse contient ' . $pirate->showGold().' pièces d\'or !');
        $response->addLine('Vous êtes à ' . $place->showCityName().'.');
        $response->addLine('La capacité de votre bateau (' . $pirate->showBoatName().') est de '. $pirate->showBoatCapacity().' caisses.');
        $response->addLine('Vous transportez actuellement '. $pirate->showBoatStock().' caisse(s).');

        $keys = array_keys($resourceList);
        foreach($keys as $key){
            if ($resourceList[$key]>0) {
                $response->addLine(' - '. $resourceList[$key].' caisse(s) de '.$key.'.');
            }
        }

        $response->addLine('');
        $response->addLine('A '. $place->showCityName(). ' '.$place->countOpenShop().' marchands sont ouverts : ');

        $traders = $place->getAvailableTraders();
        foreach ($traders as $trader){
            if ($trader->isOpen()){
            $response->addLine('- Marchand <'. $trader->showName().'> : Ressource <'.$trader->showResource().'> : stock <'.$trader->showResourceAvailable().'> : Prix unitaire <'. $trader->showActualPrice().'> po.');
            }
        }
        $response->addLine('--------------------------------');


    }

}