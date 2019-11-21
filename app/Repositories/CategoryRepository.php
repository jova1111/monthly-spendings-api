<?php

namespace App\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function create(Category $category): Category;
    public function get(string $id = null, string $name = null): ?Category;
    public function getAll(string $ownerId = null);
    public function update(Category $category);
    public function delete($id);
}
