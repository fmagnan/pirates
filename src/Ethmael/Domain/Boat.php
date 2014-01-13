<?php

namespace Ethmael\Domain;

use Ethmael\Utils\Math;

class Boat
{

    protected $name;
    protected $level;
    protected $capacity;
    protected $wood;
    protected $jewels;
    protected $resources;
    protected $gameConfig; //Array with all parameters of the game.

    const PLUS = 100;
    const MINUS = 101;


    /*
     * $config : game config file loaded in an array.
     */
    public function __construct($config)
    {

        $this->gameConfig = $config;

        // Get randomly one name for the boat (in config file)
        $boatNames = $this->gameConfig["CityName"];
        $liste = Math::randomN(1, 0, count($boatNames) - 1);
        $this->name = $boatNames[$liste[0]];

        // New boat is level 1 boat
        $this->level = 1;

        // Capacity is level x 100
        $this->capacity = $this->level * 100;

        $this->initResource();


        $this->wood = 0;
        $this->jewels = 0;
    }

    /*
     * This function use gameConfig to load an array of resource.
     * Array[ [Res1,0][Res2,0][Res3,0][Res4,0] ]
     */
    public function initResource()
    {
        $resNames = $this->gameConfig["ResourceName"];
        foreach ($resNames as $item) {
            $this->resources[$item] = 0;
        }

    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getName()
    {
        return $this->name;
    }

    public function changeName($name)
    {
        $this->name = $name;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function upgradeBoatLevel()
    {
        $this->level += 1;
        $this->capacity = $this->level * 100;
    }

    public function getStock($resourceName = "allStock")
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
        if ($quantity > $this->freeSpace()) {
            $message = sprintf('not enough free space to add %d resources ', $quantity);
            throw new \RangeException($message);
        }
        $this->resources[$resourceType] += $quantity;

    }

    public function removeResource($resourceType, $quantity)
    {
        if ($quantity > $this->getStock($resourceType)) {
            $message = sprintf('not enough Resource to get %d ', $quantity);
            throw new \RangeException($message);
        }
        $this->resources[$resourceType] -= $quantity;
    }

    public function freeSpace()
    {
        return ($this->capacity - $this->getStock());
    }


}