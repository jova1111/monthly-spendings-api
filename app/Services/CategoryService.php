<?php

namespace App\Services;

use App\Constants\CategoryConstants;
use App\Exceptions\ResourceConflictException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\TransactionRepository;

class CategoryService
{
    private $categoryRepository;
    private $transactionRepository;

    public function __construct(CategoryRepository $categoryRepository, TransactionRepository $transactionRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->transactionRepository = $transactionRepository;
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
        $category = $this->categoryRepository->get($id);
        if (!$category) {
            throw new ResourceNotFoundException('Category with an id ' . $id . ' not found.');
        }
        return $this->categoryRepository->get($id);
    }

    public function getAll(string $ownerId = null, string $name = null)
    {
        return $this->categoryRepository->getAll($ownerId, $name);
    }

    public function update(Category $user)
    {
    }

    public function delete(string $id)
    {
        $categoryToDelete = $this->categoryRepository->get($id);
        if (!$categoryToDelete) {
            throw new ResourceNotFoundException('Category with an id ' . $id . ' not found.');
        }
        if ($categoryToDelete->getName() == CategoryConstants::DEFAULT_CATEGORY_NAME) {
            throw new ResourceConflictException('Cannot delete default category.');
        }
        $userTransactions = $this->transactionRepository->getAll($categoryToDelete->getOwner()->getId());
        $this->categoryRepository->delete($id);
        $defaultCategory = $this->categoryRepository->getAll($categoryToDelete->getOwner()->getId(), CategoryConstants::DEFAULT_CATEGORY_NAME)[0];
        foreach ($userTransactions as $transaction) {
            if ($transaction->getCategory()->getName() == $categoryToDelete->getName()) {
                $transaction->getCategory()->setId($defaultCategory->getId());
                $this->transactionRepository->update($transaction);
            }
        }
    }
}
