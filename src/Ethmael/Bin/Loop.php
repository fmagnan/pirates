<?php

namespace Ethmael\Bin;

use Ethmael\Domain\Boat;
use Ethmael\Domain\City;
use Ethmael\Domain\Game;
use Ethmael\Domain\Pirate;
use Ethmael\Domain\Trader;

class Loop
{
    protected $playerName;
    protected $fh;
    protected $endOfLoop;
    protected $endOfGame;
    protected $endOfShopping;
    protected $theGame;


    public function __construct()
    {
        $this->playerName = "Gertrude";
        print "Bienvenue dans Piratess! Un jeu Magn'And'Look.\n";
        print "Pour choisir une option, entrez le choix entre crochet [].\n";

        $this->fh = fopen('php://stdin', 'r');

        $this->endOfLoop = false;
        while (!$this->endOfLoop) {
            print "\n\n";
            print sprintf("Bien le bonjour %s.\n", $this->playerName);

            print "\n---------------------------------------------------\n";
            print "[1] - Ho bordel, il faut que je change de nom !\n";
            print "[2] - Allons-y, jouons.\n";
            print "[99] - Exit.\n";
            print "> ";

            $next_line = fgets($this->fh, 1024); // read the special file to get the user input from keyboard

            switch ($next_line) {
                case "1\n":
                    $this->changePlayerName();
                    break;
                case "2\n":
                    $this->launchGame();
                    break;
                case "99\n":
                    print "Bye.\n";
                    $this->endOfLoop = true;
                    break;
                default:
                    print "Ce choix n'est pas valide. Essaie encore !\n";
                    break;
            }
        }
    }



    public function launchGame(){

        $this->initGame();
        $this->initCities();
        $this->initPirate();

        $this->endOfGame = false;
        while (!$this->endOfGame) {

            print "\n\n";
            //print sprintf("Game is starting %s.\n", $this->playerName);
            print sprintf("Re-Bonjour jeune pirate %s.", $this->playerName);
            print sprintf(" Vous êtes le Capitaine du merveilleux navire : %s !\n", $this->theGame->getPirate()->boatName());
            print sprintf("Votre bourse contient %d pièces d'or.\n", $this->theGame->getPirate()->countGold());
            print "Vous vous trouvez dans la ville de :\n";
            print sprintf("%s :", $this->theGame->getPirate()->isLocatedIn()->name());
            print sprintf(" %s\n", $this->theGame->getPirate()->isLocatedIn()->description());



            print "\n---------------------------------------------------\n";
            print "[0] - Status du jeu (Debug)\n";
            print "[1] - Ho bordel, il faut que je change de nom !\n";
            print "[2] - Ha vraiment super le nom du bateau ! Changez moi ça tit'suite..\n";
            print "[3] - Et si nous allions boire une bière dans notre cabine.\n";
            print "[4] - Au boulot Moussaillon, allons commercer.\n";
            print "[99] - Exit.\n";
            print "> ";

            $next_line = fgets($this->fh, 1024); // read the special file to get the user input from keyboard

            switch ($next_line) {
                case "0\n":
                    $this->GameStatus();
                    break;
                case "1\n":
                    $this->changePlayerName();
                    break;
                case "2\n":
                    $this->changeBoatName();
                    break;
                case "3\n":
                    $this->visitBoat();
                    break;
                case "4\n":
                    $this->visitTraders();
                    break;
                case "99\n":
                    print "You have stopped the game.\n";
                    $this->endOfGame = true;
                    break;
                default:
                    print "Ce choix n'est pas valide. Essaie encore !\n";
                    break;
            }
        }
    }



    public function changePlayerName(){
        print "New Name> ";
        $next_line = fgets($this->fh, 1024);
        $this->playerName = trim(preg_replace('/\s+/', ' ', $next_line));
    }


    public function changeBoatName(){
        print "New Boat Name> ";
        $next_line = fgets($this->fh, 1024);
        $this->theGame->getPirate()->changeBoatName(trim(preg_replace('/\s+/', ' ', $next_line)));
    }

    public function visitBoat(){
        print "Vous avez beau chercher, il n'y a aucune bière dans votre cabine !\n";
        print "Attendant que votre second vous serve un bon vieux rhum, vous jetez un coup d'oeil sur l'état de votre raffiot.\n";
        print sprintf("Ce bon vieil %s et ses ", $this->theGame->getPirate()->boatName());
        print sprintf("%d caisses entreposables en cale. \n", $this->theGame->getPirate()->getBoat()->getCapacity());

        if ($this->theGame->getPirate()->getBoat()->getStock() == 0){
            print "Le problème, c'est que les cales sont vides ! Il va falloir remplir tout ça.\n";
        }
        else {
            print "Pour l'instant, nous avons en cale :\n";
            print sprintf("- %d caisses de bois. \n", $this->theGame->getPirate()->getBoat()->getStock(Boat::WOOD));
            print sprintf("- %d coffres de joyaux. \n", $this->theGame->getPirate()->getBoat()->getStock(Boat::JEWELS));
        }

        print "Continuer ... ";
        fgets($this->fh, 1024);
        //$this->theGame->getPirate()->changeBoatName(trim(preg_replace('/\s+/', ' ', $next_line)));
    }

    public function visitTraders(){

        $this->endOfGame = false;
        while (!$this->endOfShopping) {
            print "Parcourant les ruelles de la ville, vous discutez avec différents marchands.\n";

            print "\n---------------------------------------------------\n";
            print "[0] - Status du jeu (Debug)\n";
            print "[1] - Acheter du bois à Luigi\n";
            print "[2] - Acheter des joyaux à Mario\n";
            print "[3] - \n";
            print "[4] - \n";
            print "[99] - Exit.\n";
            print "> ";

            $next_line = fgets($this->fh, 1024); // read the special file to get the user input from keyboard

            switch ($next_line) {
                case "0\n":
                    $this->GameStatus();
                    break;
                case "1\n":
                    $this->buyResourcetoTrader($this->theGame->getCityWithName($this->theGame->getPirate()->isLocatedIn()->name())->getTraderByName("Luigi"));
                    break;
                case "2\n":
                    $this->buyResourcetoTrader($this->theGame->getCityWithName($this->theGame->getPirate()->isLocatedIn()->name())->getTraderByName("Mario"));
                    break;
                case "3\n":
                    //$this->visitBoat();
                    break;
                case "4\n":
                    //$this->visitTraders();
                    break;
                case "99\n":
                    print "Bye.\n";
                    $this->endOfShopping = true;
                    break;
                default:
                    print "Ce choix n'est pas valide. Essaie encore !\n";
                    break;
            }
        }
    }

    public function buyResourcetoTrader($trader){
        $pirate =  $this->theGame->getPirate();
        $trader->sell($pirate, 4);

    }
    public function initGame(){
        $this->theGame = new Game();
    }
    public function initCities(){
        $saigon = new City("Saigon");
        $saigon->newDescription("Les Charmes de l'Asie, capitale du commerce, haaaaa Saigon !");
        $luigi = new Trader(Trader::WOOD, 10,500);
        $luigi->newName("Luigi");
        $mario = new Trader(Trader::JEWELS, 1000,80);
        $mario->newName("Mario");
        $saigon->addTrader($luigi);
        $saigon->addTrader($mario);

        $puertoRico = new City("Puerto Rico");
        $woodInRico = new Trader(Trader::WOOD, 15,300);
        $jewelsInRico = new Trader(Trader::JEWELS, 600,50);
        $puertoRico->addTrader($woodInRico);
        $puertoRico->addTrader($jewelsInRico);

        $this->theGame->addCity($saigon);
        $this->theGame->addCity($puertoRico);
    }

    public function initPirate(){
        $pirate = new Pirate();
        $pirate->giveGold(500000);
        $pirate->buyNewBoat("Petit Bateau en Mousse");
        //$pirate->getBoat()->addResource(Boat::WOOD,10);
        //$pirate->getBoat()->addResource(Boat::JEWELS,20);
        $pirate->setLocation($this->theGame->getCityWithName("Saigon"));
        $this->theGame->addPirate($pirate);
    }

    public function GameStatus(){
        print sprintf("Player name : %s.\n", $this->playerName);
        print sprintf("Pirate Boat name : %s.\n", $this->theGame->getPirate()->boatName());
        print sprintf("Pirate Boat capacity : %s.\n", $this->theGame->getPirate()->getBoat()->getCapacity());
        print sprintf("Pirate Boat WOOD Stock : %d.\n", $this->theGame->getPirate()->getBoat()->getStock(Boat::WOOD));
        print sprintf("Pirate Boat JEWELS Stock : %d.\n", $this->theGame->getPirate()->getBoat()->getStock(Boat::JEWELS));
        print sprintf("Current City name : %s.\n", $this->theGame->getPirate()->isLocatedIn()->name());
        print sprintf("Current City description : %s.\n", $this->theGame->getPirate()->isLocatedIn()->description());
    }
}