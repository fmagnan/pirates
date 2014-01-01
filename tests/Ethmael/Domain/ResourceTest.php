<?php

namespace Ethmael\Domain;

class ResourceTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    /**
     * @test
     */
    public function defaultResourceIsWood()
    {
        $resource = new Resource();
        $this->assertEquals(Resource::WOOD, $resource->getType());
    }

}