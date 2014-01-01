<?php

namespace Ethmael\Domain;

class Resource
{

    protected $type;

    const WOOD = 0;
    const JEWELS = 1;

    public function __construct($type = null)
    {
        if (is_null($type)) {
            $type = self::WOOD;
        }
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

}