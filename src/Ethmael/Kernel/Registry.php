<?php

namespace Ethmael\Kernel;

class Registry
{
    protected $entities;

    public function __construct()
    {
        $this->entities = [];
    }

    public function bind($entityName, $entity)
    {
        if (isset($this->entities[$entityName])) {
            $message = sprintf('Entity %s is already registered.', $entityName);
            throw new \Exception($message);
        }
        $this->entities[$entityName] = $entity;
    }

    public function getEntity($entityName)
    {
        if (!isset($this->entities[$entityName])) {
            $message = sprintf('Missing entity %s.', $entityName);
            throw new \Exception($message);
        }
        return $this->entities[$entityName];
    }
}