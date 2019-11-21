<?php

namespace App\Services\Contracts;

use App\Models\Category;

interface CategoryService
{
    public function create(Category $category): Category;

    public function get(string $id = null, string $name = null): ?Category;

    public function getAll(string $ownerId = null);

    public function update(Category $user);

    public function delete($id);
}
