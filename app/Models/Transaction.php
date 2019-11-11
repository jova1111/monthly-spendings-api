<?php 

namespace App\Models;

use App\Models\User;

class Transaction
{
    private $_id;
    private $_amount;
    private $_description;
    private $_created_at;
    private $_owner;
    private $_group;

    public function setId($id) 
    {
        $this->_id = $id;
    }

    public function getId() 
    {
        return $this->$id;
    }

    public function setAmount($amount) 
    {
        $this->_amount = $amount;
    }

    public function getAmonut() 
    {
        return $this->_amount;
    }

    public function setDescription($description) 
    {
        $this->$_description = $description;
    }

    public function getDescription() 
    {
        return $this->_description;
    }

    public function setCreatedAt($created_at) 
    {
        $this->_created_at = $created_at;
    }

    public function getCreatedAt() 
    {
        return $this->_created_at;
    }

    public function setOwner($owner) 
    {
        $this->_owner = $owner;
    }

    public function getOwner() 
    {
        return $this->_owner;
    }

    public function setGroup($group) 
    {
        $this->$group = $group;
    }

    public function getGroup() 
    {
        return $this->$group;
    }
}