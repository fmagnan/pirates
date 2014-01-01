<?php

namespace Ethmael\Domain;

class Trader
{

    protected $type;
    protected $quantity;

    const WOOD = 0;
    const JEWELS = 1;

    public function __construct($type = null)
    {
        if (is_null($type)) {
            $type = self::WOOD;
        }
        $this->type = $type;
        $this->quantity = 0;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

}