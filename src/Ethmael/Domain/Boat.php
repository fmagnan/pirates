<?php

namespace Ethmael\Domain;

class Boat
{

    protected $name;
    protected $level;
    protected $capacity;
    protected $wood;
    protected $jewels;
    protected $resources;

    const PLUS = 100;
    const MINUS = 101;


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

    public function getStock($resource = 0)
    {
        if ($resource == Cst::ANY) {
            return ($this->wood + $this->jewels);
        }

        if ($resource == Cst::WOOD) {
            return $this->wood;
        }

        if ($resource == Cst::JEWELS) {
            return $this->jewels;
        }

        return 0;
    }

    public function addResource($resourceType, $quantity)
    {
        if ($quantity > $this->freeSpace()) {
            $message = sprintf('not enough free space to add %d resources ', $quantity);
            throw new \RangeException($message);
        }

        $this->changeResourceQuantity($resourceType, $this::PLUS, $quantity);
    }

    public function removeResource($resourceType, $quantity)
    {
        if ($quantity > $this->getStock($resourceType)) {
            $message = sprintf('not enough Resource to get %d ', $quantity);
            throw new \RangeException($message);
        }

        $this->changeResourceQuantity($resourceType, $this::MINUS, $quantity);
    }

    public function freeSpace()
    {
        return $this->capacity - $this->getStock();
    }

    public function changeResourceQuantity($resourceId, $operator, $quantity)
    {
        if ($operator == $this::PLUS) {
            if ($resourceId == Cst::WOOD) {
                $this->wood += $quantity;
            }
            if ($resourceId == Cst::JEWELS) {
                $this->jewels += $quantity;
            }
        } else if ($operator == $this::MINUS) {
            if ($resourceId == Cst::WOOD) {
                $this->wood -= $quantity;
            }
            if ($resourceId == Cst::JEWELS) {
                $this->jewels -= $quantity;
            }
        }
    }
}