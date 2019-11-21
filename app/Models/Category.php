<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use JsonSerializable;

class Category implements JsonSerializable
{
    private $id;
    private $name;
    public $owner;
    private $creationDate;
    private $transactions = array();

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
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

    public function addTransaction(Transaction $transaction)
    {
        array_push($this->transactions, $transaction);
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
