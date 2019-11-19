<?php

namespace App\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function create(Category $category): Category;
    public function get(int $id);
    public function getAll(int $owner_id = null);
    public function update(Category $category);
    public function delete($id);
}
