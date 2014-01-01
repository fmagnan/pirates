<?php

namespace Ethmael\Domain;

class Pirate
{

    protected $gold;

    public function __construct()
    {
        $this->gold = 0;
    }

    public function giveGold($amount)
    {
        $this->gold += $amount;
    }

    public function takeGold($amount)
    {
        if ($amount > $this->gold) {
            $message = sprintf('not enough gold in purse to take %d', $amount);
            throw new \RangeException($message);
        }
        $this->gold -= $amount;
    }

    public function countGold()
    {
        return $this->gold;
    }
}