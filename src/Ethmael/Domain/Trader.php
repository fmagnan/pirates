<?php

namespace Ethmael\Domain;

class Trader
{

    protected $type;
    protected $quantity;
    protected $unitPrice;
    protected $traderName;
    protected $welcomeMessage;

    const WOOD = 0;
    const JEWELS = 1;
    const OPIUM = 2;

    public function __construct($type, $unitPrice, $quantity = 0)
    {
        $this->type = $type;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->traderName = "Boby";
        $this->welcomeMessage = "Hello";
    }

    public function getType()
    {
        return $this->type;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    public function sell(Pirate $pirate, $quantity)
    {
        if ($quantity > $this->quantity) {
            $message = sprintf('not enough quantity to sell %d units', $quantity);
            throw new \RangeException($message);
        }
        $amount = $quantity * $this->unitPrice;
        $pirate->takeGold($amount);
        $this->quantity -= $quantity;
    }

    public function newName($name)
    {
        $this->traderName = $name;
    }
    public function name()
    {
        return $this->traderName;
    }

    public function newWelcome($name)
    {
        $this->welcomeMessage = $name;
    }

    public function welcomeMessage()
    {
        return $this->welcomeMessage;
    }

}