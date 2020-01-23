<?php

namespace App\Services;

use App\Exceptions\ResourceConflictException;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepository;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Category $category): Category
    {
        if ($this->categoryRepository->getAll($category->getOwner()->getId(), $category->getName())) {
            throw new ResourceConflictException('Transaction category with given name already exists.');
        }
        return $this->categoryRepository->create($category);
    }

    public function get(string $id): ?Category
    {
        return $this->categoryRepository->get($id);
    }

    public function getAll(string $ownerId = null, string $name = null)
    {
        return $this->categoryRepository->getAll($ownerId, $name);
    }

    public function update(Category $user)
    {
    }

    public function delete($id)
    {
    }
}
