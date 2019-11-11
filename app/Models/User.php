<?php
namespace App\Models;

class User
{
    private $_id;
    private $_username;

    public function setId(int $id) 
    {
        $this->_id = $id;
    }

    public function getId() 
    {
        return $this->_id;
    }

    public function setUsername($username) 
    {
        $this->_username = $username;
    }

    public function getUsername() 
    {
        return $this->_username;
    }
}
