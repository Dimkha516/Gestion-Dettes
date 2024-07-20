<?php
namespace Entities;

class UserEntity{
    private $id;
    private $username;
    private $password;
    private $role;

    public function __set($property, $value){
        if(property_exists($this, $property)){
            $this->$property = $value;
        }
        return $this;
    }
}