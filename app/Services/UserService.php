<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\CategoryRepository;

class UserService
{
    private $userRepository;
    private $categoryRepository;

    public function __construct(UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(User $user): User
    {
        $newUser = $this->userRepository->create($user);

        // create default categories for a new user
        $noCategory = new Category;
        $noCategory->setName("Other");
        $noCategory->setOwner($newUser);
        $foodCategory = new Category;
        $foodCategory->setName("Food");
        $foodCategory->setOwner($newUser);

        $this->categoryRepository->create($noCategory);
        $this->categoryRepository->create($foodCategory);
        return $newUser;
    }

    public function get(string $id): ?User
    {
        return $this->userRepository->get($id);
    }

    public function getActiveYears(string $id)
    {
        return $this->userRepository->getActiveYears($id);
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function update(User $user)
    {
        return $this->userRepository->update($user);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }
}
