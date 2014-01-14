<?php

namespace Ethmael\Bin\Command;

use Ethmael\Domain\Boat;
use Ethmael\Domain\Cst;
use Ethmael\Kernel\Registry;
use Ethmael\Kernel\Response;

class StatusDebug extends Command
{
    protected $game;
    protected $player;

    public function __construct($player, $game)
    {
        $this->player = $player;
        $this->game = $game;
        parent::__construct('sd', 'sd: display current DEBUG game status');
    }

    public function run(Response $response, array $args=[])
    {
        $response->addLine('-----PLAYER---------------------');
        $response->addLine('Name: ' . $this->player->showName());
        $response->addLine('--------------------------------');
        $response->addLine('');



        $response->addLine('-----PIRATE---------------------');
        $pirate = $this->game->getPirate();
        if (is_null($pirate)) {
            return;
        }
        $boat = $pirate->getBoat();
        $resourceList = $boat->getResources();
        $place = $pirate->isLocatedIn();
        $response->addLine('Gold          : ' . $pirate->showGold());
        $response->addLine('Location      : ' . $place->showCityName());
        $response->addLine('Boat name     : ' . $pirate->showBoatName());
        $response->addLine('Boat capacity : ' . $pirate->showBoatCapacity());
        //print_r($boat);
        $keys = array_keys($resourceList);
        foreach($keys as $key){
            $response->addLine(' - '.$key.' : ' . $resourceList[$key]);
        }

        $response->addLine('--------------------------------');
        $response->addLine('');



        $response->addLine('-----CITIES---------------------');
        $cities = $this->game->getCities();
        foreach ($cities as $city){
            $response->addLine('- '. $city->showCityName(). ' ('.$city->countOpenShop().' traders opened): '.$city->showCityDescription());

            $traders = $city->getAvailableTraders();
            foreach ($traders as $trader){

                if ($trader->isOpen()){
                $response->addLine('--- Trader : '. $trader->showTraderName().' : '.$trader->showWelcomeMessage());
                $response->addLine('     OPEN  : '.$trader->showResourceAvailable().' '. $trader->showResource().  ' available at '.$trader->showActualPrice().' golds each.');
                }
                //else {
                //    $response->addLine('     CLOSED : '.$trader->showResourceAvailable().' '. $trader->showResource().  ' available at '.$trader->showActualPrice().' golds each.');
                //}
            }
            $response->addLine('');
        }
        $response->addLine('--------------------------------');


    }

}