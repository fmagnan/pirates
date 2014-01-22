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


    public function __construct(Settings $config)
    {
        $this->settings = $config;
        $this->closeShop();
    }

    public function initTrader($traderName, $traderWelcome, $resourceName, $basicPrice, $quantity = 0)
    {
        $this->changeName($traderName);
        $this->changeWelcomeMessage($traderWelcome);
        $this->changeResourceToSell($resourceName,$basicPrice);
        $this->provisionResource($quantity);
        $this->sellingPrice = $basicPrice;
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
        return $this->sellingPrice;
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
        $this->sellingPrice = $newPrice;
    }

    public function changeBasePrice($newPrice)
    {
        $this->basePrice = $newPrice;
    }
    public function changeResourceToSell($resourceName, $price)
    {
        $this->resourceName = $resourceName;
        $this->changeBasePrice($price);
        $this->changeActualPrice($price);
    }
}