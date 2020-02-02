<?php

namespace App\Repositories\Mongo;

use App\Constants\CategoryConstants;
use App\Exceptions\ResourceConflictException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Mongo\Models\Category as RepoCategory;
use App\Repositories\Mongo\Utils\MongoMapper;

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

    public function get(string $id): ?Category
    {
        $repoCategory = RepoCategory::find($id);
        return MongoMapper::mapRepoCategoryToCategory($repoCategory);
    }

    public function getAll(string $ownerId = null, string $name = null)
    {
        $categories = array();
        $repoCategories = RepoCategory::query();
        if ($ownerId) {
            $repoCategories->where('owner_id', $ownerId);
        }
        if ($name) {
            $repoCategories->where('name', $name);
        }
        foreach ($repoCategories->get() as $repoCategory) {
            array_push($categories, MongoMapper::mapRepoCategoryToCategory($repoCategory));
        }
        return $categories;
    }

    public function update(Category $user)
    {
    }

    public function delete(string $id)
    {
        RepoCategory::destroy($id);
    }
}
