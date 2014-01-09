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
        print "Welcome in Pirates! Game Of The Year Edition.\n";
        print "To select an option, type the choice between bracket [].\n";

        $this->fh = fopen('php://stdin', 'r');

        $this->endOfLoop = false;
        while (!$this->endOfLoop) {
            print sprintf("Hello %s.\n", $this->playerName);
            print "[1] - Please change my name !\n";
            print "[2] - Let's go to Rumble.\n";
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
            print sprintf("Game is starting %s.\n", $this->playerName);
            print sprintf("Hello Young Pirate. You are the Commander of this marvellous Ship : %s !\n", $this->theGame->getPirate()->boatName());
            print sprintf("Your purse is full of %d golds.\n", $this->theGame->getPirate()->countGold());
            print "[1] - Please change my name !\n";
            print "[2] - What's this fucking boat name ?!? Change it !.\n";
            print "[3] - Exit.\n";
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

    public function initGame(){
        $this->theGame = new Game();
    }
    public function initCities(){
        $saigon = new City("Saigon");
        $puertoRico = new City("Puerto Rico");
        $this->theGame->addCity($saigon);
        $this->theGame->addCity($puertoRico);
    }

    public function initPirate(){
        $pirate = new Pirate();
        $pirate->giveGold(500);
        $pirate->buyNewBoat("The Small Foam Boat");
        $this->theGame->addPirate($pirate);
    }



}