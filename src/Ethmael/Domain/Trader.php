<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;

class Trader
{

    protected $resourceName;
    protected $stock;
    protected $unitPrice;
    protected $shopOpen;
    protected $traderName;
    protected $welcomeMessage;
    protected $gameConfig; //Array with all parameters of the game.


    public function __construct($config)
    {
        $this->gameConfig = $config;

        // Get by default first resource (in config file)
        $resourceList = $this->gameConfig["ResourceName"];
        $this->resourceName = $resourceList[0];

        //$this->resourceName = $type;
        $this->stock = 0;
        $this->unitPrice =0 ;

        // Get randomly one name for the trader (in config file)
        $TraderNames = $this->gameConfig["TraderName"];
        $liste = Math::randomN(1, 0, count($TraderNames) - 1);
        $this->traderName = $TraderNames[$liste[0]];

        $this->welcomeMessage = "Hello";
        $this->shopOpen = true;
    }

    public function initTrader($resourceName, $unitPrice, $quantity = 0)
    {
        $this->resourceName = $resourceName;
        $this->stock = $quantity;
        $this->unitPrice = $unitPrice;
    }


    public function sell(Pirate $pirate, $quantity)
    {
        if ($quantity > $this->stock) {
            $message = sprintf('not enough quantity to sell %d units', $quantity);
            throw new \RangeException($message);
        }

        if ($quantity > $pirate->getBoat()->showFreeSpace()) {
            $message = sprintf('not enough space in boat to buy %d units', $quantity);
            throw new \RangeException($message);
        }

        $amount = $quantity * $this->unitPrice;
        $pirate->takeGold($amount);
        $pirate->getBoat()->addResource("Bois", $quantity);
        $this->stock -= $quantity;
    }

    public function showResource()
    {
        return $this->resourceName;
    }

    public function changeResourceToSell($resourceName)
    {
        $this->resourceName = $resourceName;
    }

    public function showResourceAvailable()
    {
        return $this->stock;
    }

    public function showPrice()
    {
        return $this->unitPrice;
    }

    public function changePrice($newPrice)
    {
        $this->unitPrice = $newPrice;
    }

    public function changeTraderName($name)
    {
        $this->traderName = $name;
    }
    public function showTraderName()
    {
        return $this->traderName;
    }

    public function changeWelcomeMessage($name)
    {
        $this->welcomeMessage = $name;
    }

    public function showWelcomeMessage()
    {
        return $this->welcomeMessage;
    }

    public function isOpen()
    {
        return $this->shopOpen;
    }

    public function openShop()
    {
        $this->shopOpen = true;
    }

    public function closeShop()
    {
        $this->shopOpen = false;
    }

}