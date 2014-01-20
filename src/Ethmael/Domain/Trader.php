<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;

class Trader
{

    protected $resourceName;
    protected $stock;
    protected $sellingPrice;
    protected $basePrice;
    protected $shopOpen;
    protected $traderName;
    protected $welcomeMessage;
    protected $settings; //Array with all parameters of the game.


    public function __construct($config)
    {
        $this->settings = $config;

        // Get by default first resource (in config file)
        $resourceList = $this->settings->getAllResources();
        $this->resourceName = $resourceList[0][0];
        $this->changeBasePrice($resourceList[0][2]);
        $this->changeActualPrice($resourceList[0][2]);
        $this->stock = 0;

        // Get randomly one name for the trader (in config file)
        $TraderNames = $this->settings->getAllTraders();
        $liste = Math::randomN(1, 0, count($TraderNames) - 1);
        $this->traderName = $TraderNames[$liste[0]][0];
        $this->welcomeMessage = $TraderNames[$liste[0]][1];
        $this->closeShop();
    }

    public function initTrader($traderName, $traderWelcome, $resourceName, $unitPrice, $quantity = 0)
    {
        $this->changeTraderName($traderName);
        $this->changeWelcomeMessage($traderWelcome);
        $this->changeResourceToSell($resourceName,$unitPrice);
        $this->provisionResource($quantity);
        $this->sellingPrice = $unitPrice;
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

        $amount = $quantity * $this->sellingPrice;
        $pirate->takeGold($amount);
        $boat = $pirate->getBoat();
        $boat->addResource($this->showResource(), $quantity);
        $this->stock -= $quantity;
    }

    public function buy(Pirate $pirate, $quantity)
    {
        if ($quantity > $pirate->showBoatStock($this->showResource())) {
            $message = sprintf('Pirate has not enough to sell %d units', $quantity);
            throw new \RangeException($message);
        }


        $amount = $quantity * $this->sellingPrice;
        $pirate->giveGold($amount);
        $pirate->getBoat()->removeResource($this->showResource(), $quantity);
        $this->stock += $quantity;
    }

    public function provisionResource($quantity)
    {
        $this->stock += $quantity;
    }

    public function destroyResource($quantity)
    {
        if ($quantity > $this->stock) {
            $this->stock = 0;
        }
        else {
            $this->stock -= $quantity;
        }
    }

    public function showResource()
    {
        return $this->resourceName;
    }

    public function changeResourceToSell($resourceName, $price)
    {
        $this->resourceName = $resourceName;
        $this->changeBasePrice($price);
        $this->changeActualPrice($price);
    }

    public function showResourceAvailable()
    {
        return $this->stock;
    }

    public function showActualPrice()
    {
        return $this->sellingPrice;
    }

    public function changeActualPrice($newPrice)
    {
        $this->sellingPrice = $newPrice;
    }

    public function showBasePrice()
    {
        return $this->basePrice;
    }

    public function changeBasePrice($newPrice)
    {
        $this->basePrice = $newPrice;
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