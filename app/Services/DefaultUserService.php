<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Services\Contracts\UserService;

class DefaultUserService implements UserService
{
    private $_userRepository;
    private $_categoryRepository;

    public function __construct(UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_categoryRepository = $categoryRepository;
    }

    public function create(User $user): User
    {
        $newUser = $this->_userRepository->create($user);

        // create default categories for a new user
        $noCategory = new Category;
        $noCategory->setName("No category");
        $noCategory->setOwner($newUser);
        $foodCategory = new Category;
        $foodCategory->setName("Food");
        $foodCategory->setOwner($newUser);

        $this->_categoryRepository->create($noCategory);
        $this->_categoryRepository->create($foodCategory);
        return $newUser;
    }

    public function get(string $id): ?User
    {
        return $this->_userRepository->get($id);
    }

    public function getByEmailAndPassword(string $email, string $password): ?User
    {
        return $this->_userRepository->getByEmailAndPassword($email, $password);
    }

    public function getAll()
    {
        return $this->_userRepository->getAll();
    }

    public function update(User $user)
    {
        return $this->_userRepository->update($user);
    }

    public function delete($id)
    {
        return $this->_userRepository->delete($id);
    }
}
