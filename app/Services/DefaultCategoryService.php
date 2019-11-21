<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\Contracts\CategoryService;

class DefaultCategoryService implements CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Category $category): Category
    {
        return $this->categoryRepository->create($category);
    }

    public function get(string $id = null, string $name = null): ?Category
    {
        return $this->categoryRepository->get($id, $name);
    }

    public function getAll(string $ownerId = null)
    {
        return $this->categoryRepository->getAll($ownerId);
    }

    public function update(Category $user)
    { }

    public function delete($id)
    { }
}
