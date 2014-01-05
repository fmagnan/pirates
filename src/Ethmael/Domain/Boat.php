<?php

namespace Ethmael\Domain;

class Boat
{

    protected $name;
    protected $level;
    protected $capacity;
    protected $wood;
    protected $jewels;

    const ANY = 0;
    const WOOD = 1;
    const JEWELS = 2;



    public function __construct($name = "default")
    {
        $this->name = $name;
        $this->level = 1;
        $this->capacity = $this->level * 100;
        $this->wood = 0;
        $this->jewels = 0;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getName()
    {
        return $this->name;
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


    public function getStock($resource = 0)
    {
        if ($resource == $this::ANY) {
            $stock = ($this->wood + $this->jewels);
            return $stock;
        }

        if ($resource == $this::WOOD) {
            $stock = $this->wood;
            return $stock;
        }

        if ($resource == $this::JEWELS) {
            $stock = $this->jewels;
            return $stock;
        }
    }

    public function addResource($resourceType, $quantity)
    {
        if ($quantity > $this->freeSpace()) {
            $message = sprintf('not enough free space to add %d resources ', $quantity);
            throw new \RangeException($message);
        }

        if ($resourceType == $this::WOOD) {
            $this->wood += $quantity;
        }

        if ($resourceType == $this::JEWELS) {
            $this->$jewels += $quantity;
        }
    }

    public function freeSpace()
    {
        return $this->capacity - $this->getStock();
    }

}