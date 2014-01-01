<?php

namespace Ethmael\Domain;

class City
{

    protected $resources;

    public function __construct()
    {
        $this->resources = [];
    }

    public function getAvailableResources()
    {
        return $this->resources;
    }

    public function addResource(Resource $resource)
    {
        $this->resources[] = $resource;
    }

    public function canDealWith(Resource $resource)
    {
        foreach ($this->resources as $item) {
            if ($resource->getType() === $item->getType()) {
                return true;
            }
        }
        return false;
    }

}

