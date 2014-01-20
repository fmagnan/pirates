<?php

namespace Ethmael\Domain;


class Boat
{

    protected $name;
    protected $level;
    protected $capacity;
    protected $resources;
    protected $settings; //Array with all parameters of the game.

    public function __construct(Settings $config, $name)
    {
        $this->settings = $config;
        $this->changeName($name);
        $this->changeLevel(1);
        $this->updateCapacity();
        $this->initResource();
    }

    public function initResource()
    {
        $resNames = $this->settings->getAllResources();
        foreach ($resNames as $item) {
            $this->resources[$item[0]] = 0;
        }
    }

    public function destroyStock()
    {
        $this->initResource();
    }

    public function upgradeBoatLevel()
    {
        if ($this->showLevel() == 10 ) {
            $message = "Boat level can't be updraded (boat already level 10).";
            throw new \RangeException($message);
        }

        $this->changeLevel($this->showLevel() + 1);
        $this->updateCapacity();
    }

    public function downgradeBoatLevel()
    {
        if ($this->showLevel() == 1 ) {
            $message = "Boat level can't be downgraded (boat already level 1).";
            throw new \RangeException($message);
        }
        $this->changeLevel($this->showLevel() - 1);
        $this->updateCapacity();
    }

    public function getResources()
    {
        return $this->resources;
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

    public function removeAsManyResourceAsPossible($resourceType, $quantity)
    {
        if ($quantity > $this->showStock($resourceType)) {
            $quantity = $this->showStock($resourceType);
        }
        $this->removeResource($resourceType, $quantity);
    }

    /*
    * -----  SHOW METHOD
    */
    public function showLevel()
    {
        return $this->level;
    }

    public function showBoatName()
    {
        return $this->name;
    }

    public function showCapacity()
    {
        return $this->capacity;
    }

    public function showFreeSpace()
    {
        return ($this->capacity - $this->showStock());
    }

    public function showStock($resourceName = "allStock")
    {
        if ($resourceName == "allStock") {
            $stock = 0;
            foreach ($this->resources as $line) {
                $stock += $line;
            }
            return $stock;
        } else {
            return $this->resources[$resourceName];
        }
    }

    /*
     * -----  CHANGE METHOD
     */
    public function changeName($name)
    {
        $this->name = $name;
    }

    public function changeLevel($level)
    {
        $this->level = $level;
    }

    public function updateCapacity()
    {
        $this->capacity = $this->level * 100;
    }


}