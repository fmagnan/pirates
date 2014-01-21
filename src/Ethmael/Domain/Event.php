<?php

namespace Ethmael\Domain;


class Event {

    protected $settings; //Array with all parameters of the game.

    public function __construct($config)
    {
        $this->settings = $config;
    }

    public function launchEvent($eventNum, $gravity, $cities, $pirate)
    {
        switch ($eventNum) {
            case 1:
                return $this->goldEvent($gravity, $pirate);
                break;
            case 2:
                return $this->boatEvent($gravity, $pirate);
                break;
            case 3:
                return $this->stockEvent($gravity, $pirate);
                break;
        }
    }

    public function goldEvent($gravity, Pirate $pirate)
    {
        if ($gravity < 6) { //Bonus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            $bonus = 8 - $gravity;
            $nbGold = pow(($bonus + $pirateLevel),2)*10;
            $message = "Au cours de votre voyage, vous croisez un navire de la flotte marchande Belge.\n";
            $message .="A votre grande surprise, le bateau est vide ... Mais la bourse du Capitaine est pleine.\n";
            $message .="Vous coulez le bateau et son équipage et récupérez ".$nbGold." pièces d'or.\n";
            $pirate->giveGold($nbGold);
            return $message;
        }
        else { //Malus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            $malus = $gravity - 3;
            $nbGold = pow(($malus + $pirateLevel),2)*5;
            $message ="Le jour se lève sur la mer. A l'horizon, un drapeau flotte.\n";
            $message .="C'est un navire de guerre de la flotte Anglaise et il fonce droit sur vous !\n";
            $message .="Ne pouvant lutter, vous êtes abordé. Tel de vulgaires pirates, ils prennent l'or qu'ils trouvent.\n";
            $message .="C'est en les voyant partir que vous jurez devant votre équipage que vous récupèrerez ces ".$nbGold." pièces d'or par tous les moyens.\n";
            $pirate->stealGold($nbGold);
            return $message;
        }
    }
    public function boatEvent($gravity, Pirate $pirate)
    {
        if ($gravity < 3) { //Bonus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            if ($pirateLevel<12){
                $pirate->upgradeBoatLevel();
                $message ="Vous tentez de convaincre ce capitaine d'eau douce qu'il n'a pas besoin d'un si gros bateau, mais il ne comprend pas !\n";
                $message .="Peu importe, ce gros bateau est maintenant à vous !\n";
                return $message;
            }
            else {
                $message ="Vous avez beau lorgner sur ce navire que vous venez d'aborder, il n'est pas mieux que le votre.\n";
                return $message;
            }
        }
        else if ($gravity > 8) { //Malus
            $pirateLevel = $pirate->showBoatCapacity()/100;
            if ($pirateLevel > 1){
                $pirate->downgradeBoatLevel();
                $pirate->looseStock();
                $message ="Le problème sur la mer, c'est que le plus fort a toujours raison !\n";
                $message .="C'est d'ailleurs un sacré problème lorsque l'on a le sabre sous la gorge.\n";
                $message .="C'est avec la larme à l'oeuil que vous voyez votre ancien navire et sa cargaison s'enfuir.\n";
                $message .="Il ne vous reste plus qu'à faire le tour de ce nouveau moyen de transport.\n";
                return $message;
            }
            else {
                $message ="Votre bateau est dans un tel état que ce Pirate vous le laisse et continue sa route.\n";
                return $message;
            }
        }
        else {
            $message ="Vous voguez sur les mers du Sud sans encombre.\n";
            return $message;
        }
    }

    public function stockEvent($gravity, Pirate $pirate)
    {
        $resources = $this->settings->getAllResources();
        if ($gravity < 4) { //Bonus
            $numResource = rand(0,count($resources)-1);
            $resource = $resources[$numResource][0];
            $resourceLevel = $resources[$numResource][1];
            $quantityFound = (4 - $resourceLevel) * 10;
            $pirate->giveResource($resource,$quantityFound);

            $message ="Vous venez de trouver des caisses (".$resource." x ".$quantityFound.") flottant sur l'eau.\n";
            $message .="Vous les stockez dans votre calle, tout heureux de cette trouvaille.\n";
            return $message;
        }
        else if ($gravity > 7) { //Malus

            $message ="Vous voguez sur les mers du Sud sans encombre, mais ça aurait pu être pire !.\n";
            return $message;

        }
        else {
            $message = "Vous voguez sur les mers du Sud sans encombre.\n";
            return $message;
        }
    }
} 