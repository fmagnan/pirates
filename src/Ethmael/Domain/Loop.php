<?php

namespace Ethmael\Domain;

class Loop
{
    protected $playerName;
    protected $fh;
    protected $endOfLoop;
    protected $endOfGame;
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
            print "[3] - Exit.\n";
            print "> ";

            $next_line = fgets($this->fh, 1024); // read the special file to get the user input from keyboard

            switch ($next_line) {
                case "1\n":
                    $this->changePlayerName();
                    break;
                case "2\n":
                    $this->launchGame();
                    break;
                case "3\n":
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
            print "[1] - Ho bordel, il faut que je change de nom !\n";
            print "[2] - Ha vraiment super le nom du bateau ! Changez moi ça tit'suite..\n";
            print "[3] - Et si nous allions boire une bière dans notre cabine.\n";
            print "[4] - Exit.\n";
            print "> ";

            $next_line = fgets($this->fh, 1024); // read the special file to get the user input from keyboard

            switch ($next_line) {
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

        print "Continuer ... ";
        $next_line = fgets($this->fh, 1024);
        //$this->theGame->getPirate()->changeBoatName(trim(preg_replace('/\s+/', ' ', $next_line)));
    }

    public function initGame(){
        $this->theGame = new Game();
    }
    public function initCities(){
        $saigon = new City("Saigon");
        $saigon->newDescription("Les Charmes de l'Asie, capitale du commerce, haaaaa Saigon !");
        $woodInSaigon = new Trader(Trader::WOOD, 10,500);
        $jewelsInSaigon = new Trader(Trader::JEWELS, 1000,80);
        $saigon->addTrader($woodInSaigon);
        $saigon->addTrader($jewelsInSaigon);

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
        $pirate->giveGold(500);
        $pirate->buyNewBoat("Petit Bateau en Mousse");
        $pirate->setLocation($this->theGame->getCityWithName("Saigon"));
        $this->theGame->addPirate($pirate);
    }

}