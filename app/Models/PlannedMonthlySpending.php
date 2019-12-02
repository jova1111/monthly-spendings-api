<?php

namespace App\Models;

use App\Models\User;
use JsonSerializable;

class PlannedMonthlySpending implements JsonSerializable
{
    private $id;
    private $value;
    private $owner;
    private $creationDate;

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setValue(int $value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
