<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService 
{
    private $_users;

    public function __construct(UserRepository $users)
    {
        $this->_users = $users;
    }

    public function create(User $user)
    {
        return $this->_users.create($user);
    }

    public function get(int $id)
    {
        return $this->_users.get($id);
    }

    public function getAll()
    {
        return $this->_users.getAll();
    }

    public function update(User $user)
    {
        return $this->_users.update($user);
    }

    public function delete($id) 
    {
        return $this->_users.delete($id);
    }
}