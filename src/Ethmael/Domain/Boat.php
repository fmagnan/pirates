<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;

class Boat
{

    protected $name;
    protected $level;
    protected $capacity;
    protected $resources;
    protected $gameConfig; //Array with all parameters of the game.

    /*
     * $config : game config file in array format.
     */
    public function __construct($config)
    {

        $this->gameConfig = $config;

        // Get randomly one name for the boat (in config file)
        $boatNames = $this->gameConfig["BoatName"];
        $liste = Math::randomN(1, 0, count($boatNames) - 1);
        $this->name = $boatNames[$liste[0]];

        // New boat is level 1 boat
        $this->level = 1;

        // Capacity is level x 100
        $this->capacity = $this->level * 100;

        $this->initResource();
    }

    /*
     * This function use gameConfig to load an array of resource.
     * Array[ [Res1,0][Res2,0][Res3,0][Res4,0] ]
     */
    public function initResource()
    {
        $resNames = $this->gameConfig["ResourceName"];
        foreach ($resNames as $item) {
            $this->resources[$item[0]] = 0;
        }

    }

    public function showLevel()
    {
        return $this->level;
    }

    public function showBoatName()
    {
        return $this->name;
    }

    public function changeName($name)
    {
        $this->name = $name;
    }

    public function showCapacity()
    {
        return $this->capacity;
    }

    public function upgradeBoatLevel()
    {
        $this->level += 1;
        $this->capacity = $this->level * 100;
    }

    public function downgradeBoatLevel()
    {
        $this->level -= 1;
        $this->capacity = $this->level * 100;
    }

    public function getResources()
    {
        //print_r($this->resources);
        return $this->resources;
    }

    public function showStock($resourceName = "allStock")
    {
        if ($resourceName == "allStock") {
            $stock = 0;
            foreach ($this->resources as $line) {
                $stock += $line;
            }
            return $stock;
        }
        else {
            return $this->resources[$resourceName];
        }
    }

    public function addResource($resourceType, $quantity)
    {
        if ($quantity > $this->showFreeSpace()) {
            $message = sprintf('not enough free space to add %d resources ', $quantity);
            throw new \RangeException($message);
        }
        $this->resources[$resourceType] += $quantity;

    }

    public function addAsManyResourceAsPossible($resourceType, $quantity)
    {
        if ($quantity > $this->showFreeSpace()) {
            $quantity = $this->showFreeSpace();
        }
        $this->addResource($resourceType, $quantity);

    }

    public function removeResource($resourceType, $quantity)
    {
        if ($quantity > $this->showStock($resourceType)) {
            $message = sprintf('not enough Resource to get %d ', $quantity);
            throw new \RangeException($message);
        }
        $this->resources[$resourceType] -= $quantity;
    }

    public function showFreeSpace()
    {
        return ($this->capacity - $this->showStock());
    }


    public function destroyStock()
    {
        $this->initResource();
    }
}