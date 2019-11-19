<?php

namespace App\Models;

use App\Models\Category;

class User
{
    public $id;
    private $_username;
    private $_email;
    private $_password;
    private $_categories = array();

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setPassword(string $password)
    {
        $this->_password = $password;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function addCategory(Category $category)
    {
        $this->_categories . push($category);
    }

    public function getCategories()
    {
        return $this->_categories;
    }
}
