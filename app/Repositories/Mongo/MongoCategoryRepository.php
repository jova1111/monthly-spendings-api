<?php

namespace App\Repositories\Mongo;

use App\Models\Category;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\Mongo\Models\Category as RepoCategory;

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

    public function get(string $id = null, string $name = null): ?Category
    {
        if ($id) {
            $repoCategory = RepoCategory::find($id);
        } else {
            $repoCategory = RepoCategory::where(['name' => $name])->first();
        }
        return $this->mapRepoCategoryToCategory($repoCategory);
    }

    public function getAll(string $ownerId = null)
    {
        $categories = array();
        $repoCategories = null;
        if ($ownerId) {
            $repoCategories = RepoCategory::where(['owner_id' => $ownerId])->get();
        } else {
            $repoCategories = RepoCategory::all();
        }
        foreach ($repoCategories as $repoCategory) {
            array_push($categories, $this->mapRepoCategoryToCategory($repoCategory));
        }
        return $categories;
    }

    public function update(Category $user)
    { }

    public function delete($id)
    { }

    private function mapRepoCategoryToCategory(?RepoCategory $repoCategory): ?Category
    {
        if (is_null($repoCategory)) {
            return null;
        }
        $category = new Category;
        $category->setName($repoCategory->name);
        $category->setId($repoCategory->id);
        $category->setCreationDate($repoCategory->created_at->toDateTimeString());

        $owner = new User;
        $owner->setId($repoCategory->owner->id);
        $owner->setEmail($repoCategory->owner->email);
        $owner->setUsername($repoCategory->owner->username);
        $category->setOwner($owner);
        return $category;
    }
}
