<?php

namespace App\Services;

use App\Constants\CategoryConstants;
use App\Exceptions\ResourceNotFoundException;
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

        // create default category for a new user
        $noCategory = new Category;
        $noCategory->setName(CategoryConstants::DEFAULT_CATEGORY_NAME);
        $noCategory->setOwner($newUser);

        $this->categoryRepository->create($noCategory);
        return $newUser;
    }

    public function get(string $id): ?User
    {
        return $this->userRepository->get($id);
    }

    public function getActiveYears(string $id)
    {
        $user = $this->userRepository->get($id);
        if (!$user) {
            throw new ResourceNotFoundException('User with an id ' . $id . ' not found.');
        }
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
