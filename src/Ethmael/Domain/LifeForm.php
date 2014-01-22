<?php
/**
 * Created by PhpStorm.
 * User: SESA160949
 * Date: 22/01/14
 * Time: 12:50
 */

namespace Ethmael\Domain;


class LifeForm {

    protected $name;
    protected $welcomeMessage;
    protected $gold;

    public function __construct()
    {
    }

    public function giveGold($amount)
    {
        $this->gold += $amount;
        return $this->showGold();
    }


    public function takeGold($amount)
    {
        if ($amount > $this->gold) {
            $message = sprintf("Pas assez d'or pour payer %d po.", $amount);
            throw new \RangeException($message);
        }
        $this->gold -= $amount;

        return $this->showGold();
    }

    public function stealGold($amount)
    {
        if ($this->gold < $amount) {
            $this->gold = 0;
        }
        else {
            $this->gold -= $amount;
        }

        return $this->showGold();
    }

    /*
     * -----  SHOW METHOD
     */
    public function showWelcomeMessage()
    {
        return $this->welcomeMessage;
    }

    public function showName()
    {
        return $this->name;
    }


    /*
     * -----  CHANGE METHOD
     */
    public function changeWelcomeMessage($name)
    {
        $this->welcomeMessage = $name;
    }
    public function changeName($name)
    {
        $this->name = $name;
    }

} 