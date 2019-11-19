<?php

namespace App\Repositories\Mongo;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Mongo\Models\Category as RepoCategory;
use App\Repositories\Mongo\Models\User as RepoUser;

class MongoCategoryRepository implements CategoryRepository
{
    public function create(Category $category): Category
    {
        $newCategory = new RepoCategory;
        $newCategory->name = $category->getName();
        $newCategory->owner_id = $category->getOwner()->getId();
        $newCategory->save();

        $category->setId($newCategory->id);
        return $category;
    }

    public function get(int $id)
    { }

    public function getAll(int $owner_id = null)
    { }

    public function update(Category $user)
    { }

    public function delete($id)
    { }
}
