<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use App\Models\User;
use App\Services\Contracts\CategoryService;
use App\TransactionCategory;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAllUserCategories()
    {
        $categories = $this->categoryService->getAll(auth()->user()->id);
        return response()->json($categories, 200);
    }

    public function create(CreateCategoryRequest $request)
    {
        if ($this->categoryService->get(null, $request['name'])) {
            return response()->json(['message' => 'Transaction category with given name already exists.'], 409);
        }
        $owner = new User;
        $owner->setId(auth()->user()->id);

        $category = new Category;
        $category->setName($request['name']);
        $category->setOwner($owner);;
        return response()->json($this->categoryService->create($category), 201);
    }
}
