<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;

class Trader extends LifeForm
{

    protected $resourceName;
    protected $stock;
    protected $sellingPrice;
    protected $basePrice;
    protected $shopOpen;
    protected $settings;
    protected $currentTurn;


    public function __construct(Settings $config)
    {
        $this->settings = $config;
        $this->closeShop();
        $this->currentTurn = 1;
    }

    public function initTrader($traderName, $traderWelcome, $resourceName, $basicPrice, $quantity = 0)
    {
        $this->changeName($traderName);
        $this->changeWelcomeMessage($traderWelcome);
        $this->changeResourceToSell($resourceName,$basicPrice);
        $this->provisionResource($quantity);
        $this->initSellingPriceForGame();
    }

    public function initSellingPriceForGame()
    {
        $nbMaxTurn = $this->settings->getParameterNbTurn();
        $previousPrice = intval($this->basePrice + ($this->basePrice * (rand(-20,20) / 100)));
        for ($i=0;$i<$nbMaxTurn;$i++) {
            $price = intval($previousPrice + ($this->basePrice * (rand(-10,10) / 100)));
            $this->sellingPrice[$i] = $price;
            $previousPrice = $price;
        }

    }

    /*
    * TODO launch new turn in the trader
    */
    public function newTurn($turn)
    {
        $this->currentTurn = $turn;
    }

    /*
    * TODO launch new turn in the trader
    */
    public function newTurn($turn)
    {
        $newPrice = intval($this->basePrice + ($this->basePrice * (rand(-20,20) / 100)));
        $this->changeActualPrice($newPrice);
    }


    public function sell(Pirate $pirate, $quantity)
    {
        if ($quantity > $this->showResourceAvailable()) {
            $message = sprintf("Le marchand n'a pas assez de cette resource pour en vendre %d caisses", $quantity);
            throw new \RangeException($message);
        }

        if ($quantity > $pirate->getBoat()->showFreeSpace()) {
            $message = sprintf("Pas assez de place dans le bateau pour stocker %d caisses", $quantity);
            throw new \RangeException($message);
        }

        $amount = $quantity * $this->showActualPrice();
        $pirate->takeGold($amount);
        $boat = $pirate->getBoat();
        $boat->addResource($this->showResource(), $quantity);
        $this->destroyResource($quantity);
    }

    public function buy(Pirate $pirate, $quantity)
    {
        if ($quantity > $pirate->showBoatStock($this->showResource())) {
            $message = sprintf("Vous n'avez pas assez de cette resource pour en vendre %d caisses", $quantity);
            throw new \RangeException($message);
        }

        $amount = $quantity * $this->showActualPrice();
        $pirate->giveGold($amount);
        $pirate->getBoat()->removeResource($this->showResource(), $quantity);
        $this->provisionResource($quantity);
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

    /*
    * -----  SHOW METHOD
    */
    public function showResource()
    {
        return $this->resourceName;
    }

    public function showBasePrice()
    {
        return $this->basePrice;
    }

    public function showActualPrice()
    {
        return $this->sellingPrice[$this->currentTurn - 1];
    }

    public function showResourceAvailable()
    {
        return $this->stock;
    }

    /*
    * -----  CHANGE METHOD
    */
    public function changeActualPrice($newPrice)
    {
        $this->sellingPrice[$this->currentTurn] = $newPrice;
    }

    public function changeBasePrice($newPrice)
    {
        $this->basePrice = $newPrice;
    }
    public function changeResourceToSell($resourceName, $price)
    {
        $this->resourceName = $resourceName;
        $this->changeBasePrice($price);
        //$this->changeActualPrice($price);
    }
}