<?php

namespace App\Repositories;

use App\Models\Transaction;

interface TransactionRepository 
{
    public function create(Transaction $user);
    public function get(int $id);
    public function getAll(int $owner_id = null);
    public function update(Transaction $user);
    public function delete($id);
}