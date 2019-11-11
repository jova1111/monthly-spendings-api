<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository 
{
    public function create(User $user);
    public function get(int $id);
    public function getAll();
    public function update(User $user);
    public function delete($id);
}