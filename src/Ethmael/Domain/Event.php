<?php

namespace Ethmael\Domain;
use Ethmael\Kernel\Response;

class Event {

    protected $gameConfig; //Array with all parameters of the game.


    /*
     * $config : game config file in array format.
     */
    public function __construct()
    {

    }

    public function launchEvent($eventNum, $gravity, $cities, $pirate, Response $response)
    {
        switch ($eventNum) {
            case 1:
                $this->encounterBoat($gravity, $cities, $pirate, $response);
                break;
            case 2:
                $this->encounterBoat($gravity, $cities, $pirate, $response);
                break;
            case 3:
                $this->encounterBoat($gravity, $cities, $pirate, $response);
                break;
        }
    }

    public function encounterBoat($gravity, $cities, Pirate $pirate,Response $response)
    {
        if ($gravity < 7) {

            $pirateLevel = $pirate->showBoatCapacity()/100;
            $bonus = 9 - $gravity;
            $nbGold = pow(($bonus + $pirateLevel),2)*10;
            $response->addLine("Au cours de votre voyage, vous croisez un navire de la flotte marchande Belge.");
            $response->addLine("A votre grande surprise, le bateau est vide ... Mais la bourse du Capitaine est pleine.");
            $response->addLine("Vous coulez le bateau et son équipage et récupérez ".$nbGold." pièces d'or.");
            $pirate->giveGold($nbGold);
        }
        else {
            $pirateLevel = $pirate->showBoatCapacity()/100;
            $malus = $gravity - 4;
            $nbGold = pow(($malus + $pirateLevel),2)*5;
            $response->addLine("Le jour se lève sur la mer. A l'horizon, un drapeau flotte.");
            $response->addLine("C'est un navire de guerre de la flotte Anglaise et il fonce droit sur vous !");
            $response->addLine("Ne pouvant lutter, vous êtes abordé. Tel de vulgaires pirates, ils prennent l'or qu'ils trouvent.");
            $response->addLine("C'est en les voyant partir que vous jurez devant votre équipage que vous récupèrerez ces ".$nbGold." pièces d'or par tous les moyens.");

            $pirate->stealGold($nbGold);
        }

    }

} 