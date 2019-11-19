<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;

class Category
{
    private $_id;
    private $_name;
    private $_owner;
    private $_transactions = array();

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName(string $name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setOwner(User $owner)
    {
        $this->_owner = $owner;
    }

    public function getOwner()
    {
        return $this->_owner;
    }

    public function addTransaction(Transaction $transaction)
    {
        $this->_transactions . push($transaction);
    }

    public function getTransactions()
    {
        return $this->_transactions;
    }
}
