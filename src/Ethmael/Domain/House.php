<?php
/**
 * Created by PhpStorm.
 * User: SESA160949
 * Date: 22/01/14
 * Time: 12:50
 */

namespace Ethmael\Domain;


class House {

    protected $name;
    protected $description;
    protected $status;

    public function __construct()
    {
        $this->status = false;
    }
    public function isOpen()
    {
        return $this->status;
    }

    public function open()
    {
        $this->status = true;
    }

    public function close()
    {
        $this->status = false;
    }

    
    /*
     * -----  SHOW METHOD
     */
    public function showDescription()
    {
        return $this->description;
    }

    public function showName()
    {
        return $this->name;
    }


    /*
     * -----  CHANGE METHOD
     */
    public function changeDescription($desc)
    {
        $this->description = $desc;
    }
    public function changeName($name)
    {
        $this->name = $name;
    }

} 