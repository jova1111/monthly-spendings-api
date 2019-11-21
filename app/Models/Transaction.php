<?php

namespace App\Models;

use App\Models\User;
use JsonSerializable;

class Transaction implements JsonSerializable
{
    private $id;
    private $amount;
    private $description;
    private $creationDate;
    private $owner;
    private $category;

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    public function getAmonut()
    {
        return $this->amount;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
