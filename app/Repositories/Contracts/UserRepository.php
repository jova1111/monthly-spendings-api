<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepository
{
    public function create(User $user): User;
    public function get(string $id): ?User;
    public function getByEmail(string $email): ?User;
    public function getActiveYears(string $id);
    public function getAll();
    public function update(User $user);
    public function delete($id);
}
