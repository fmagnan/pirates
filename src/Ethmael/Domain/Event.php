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

    public function launchEvent($config, $eventNum, $gravity, $cities, $pirate, Response $response)
    {
        $this->gameConfig = $config;
        $response->addLine("DEBUG EVENT : numEvent=".$eventNum." gravity=".$gravity);
        switch ($eventNum) {
            case 1:
                $this->goldEvent($gravity, $cities, $pirate, $response);
                break;
            case 2:
                $this->boatEvent($gravity, $cities, $pirate, $response);
                break;
            case 3:
                $this->stockEvent($gravity, $cities, $pirate, $response);
                break;
        }
    }

    public function goldEvent($gravity, $cities, Pirate $pirate,Response $response)
    {
        if ($gravity < 7) { //Bonus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            $bonus = 9 - $gravity;
            $nbGold = pow(($bonus + $pirateLevel),2)*10;
            $response->addLine("Au cours de votre voyage, vous croisez un navire de la flotte marchande Belge.");
            $response->addLine("A votre grande surprise, le bateau est vide ... Mais la bourse du Capitaine est pleine.");
            $response->addLine("Vous coulez le bateau et son équipage et récupérez ".$nbGold." pièces d'or.");
            $pirate->giveGold($nbGold);
        }
        else { //Malus
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
    public function boatEvent($gravity, $cities, Pirate $pirate, Response $response)
    {
        if ($gravity < 4) { //Bonus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            if ($pirateLevel<12){
                $pirate->upgradeBoatLevel();
                $response->addLine("Vous tentez de convaincre ce capitaine d'eau douce qu'il n'a pas besoin d'un si gros bateau, mais il ne comprend pas !");
                $response->addLine("Peu importe, ce gros bateau est maintenant à vous !");
            }
            else {
                $response->addLine("Vous avez beau lorgner sur ce navire que vous venez d'aborder, il n'est pas mieux que le votre.");
            }
        }
        else if ($gravity > 9) { //Malus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            if ($pirateLevel > 1){
                $pirate->downgradeBoatLevel();
                $pirate->looseStock();
                $response->addLine("Le problème sur la mer, c'est que le plus fort a toujours raison !");
                $response->addLine("C'est d'ailleurs un sacré problème lorsque l'on a le sabre sous la gorge.");
                $response->addLine("C'est avec la larme à l'oeuil que vous voyez votre ancien navire et sa cargaison s'enfuir.");
                $response->addLine("Il ne vous reste plus qu'à faire le tour de ce nouveau moyen de transport.");
            }
            else {
                $response->addLine("Votre bateau est dans un tel état que ce Pirate vous le laisse et continue sa route.");
            }
        }
        else {
            $response->addLine("Vous voguez sur les mers du Sud sans encombre");
        }
    }

    public function stockEvent($gravity, $cities, Pirate $pirate, Response $response)
    {
        $resources = $this->gameConfig["ResourceName"];
        if ($gravity < 4) { //Bonus
            $numResource = rand(0,count($resources));
            $resource = $resources[$numResource][0];
            $resourceLevel = $resources[$numResource][1];
            $quantityFound = (4 - $resourceLevel) * 10;
            $pirate->giveResource($resource,$quantityFound);

            $response->addLine("Vous venez de trouver des caisses (".$resource." x ".$quantityFound.") flottant sur l'eau.");
            $response->addLine("Vous les stockez dans votre calle, tout heureux de cette trouvaille.");

        }
        else if ($gravity > 9) { //Malus

            $response->addLine("Vous voguez sur les mers du Sud sans encombre");

        }
        else {
            $response->addLine("Vous voguez sur les mers du Sud sans encombre");
        }
    }
} 