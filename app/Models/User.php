<?php

namespace App\Models;

use App\Models\Category;
use JsonSerializable;

class User implements JsonSerializable
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $categories = array();

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function addCategory(Category $category)
    {
        array_push($this->categories, $category);
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
