<?php

namespace App\Repositories\Contracts;

use App\Models\Category;

interface CategoryRepository
{
    public function create(Category $category): Category;
    public function get(string $id): ?Category;
    public function getAll(string $ownerId = null, string $name = null);
    public function update(Category $category);
    public function delete($id);
}
