<?php

namespace Ethmael\Domain;

class Pirate
{

    protected $gold;
    protected $boat;
    protected $currentCity;
    protected $gameConfig; //Array with all parameters of the game.

    /*
     * $config : game config file loaded in an array.
     */
    public function __construct($config)
    {
        $this->gameConfig = $config;
        $this->gold = 0;
    }

    /*
     * This function give gold to the pirate.
     * Pirate always accept gold !
     * $amount : amount of gold given to the pirate
     * @return : new amount of gold.
     */
    public function giveGold($amount)
    {
        $this->gold += $amount;
        return $this->countGold();
    }

    /*
     * This function take gold from the pirate.
     * And the pirate doesn't like that.
     * $amount : amount of gold taken from the pirate
     * @return : new amount of gold.
     * exception : send exception if the pirate hasn't enough gold.
     */
    public function takeGold($amount)
    {
        if ($amount > $this->gold) {
            $message = sprintf('not enough gold in purse to take %d', $amount);
            throw new \RangeException($message);
        }
        $this->gold -= $amount;

        return $this->countGold();
    }

    /*
    * @return : the amount og gold owned by the pirate.
    */
    public function countGold()
    {
        return $this->gold;
    }

    public function buyNewBoat()
    {
        $newBoat = new Boat($this->gameConfig);
        $this->boat = $newBoat;
    }

    public function changeBoatName($name)
    {
        $this->boat->changeName($name);
    }

    public function boatName()
    {
        return $this->boat->getName();
    }

    public function setLocation ($city) {
        $this->currentCity = $city;
    }

    public function isLocatedIn () {
        return $this->currentCity;
    }

    public function getBoat()
    {
        return $this->boat;
    }

}