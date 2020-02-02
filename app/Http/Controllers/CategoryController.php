<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Models\Category;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct()
    {
        $this->categoryService = App::make(CategoryService::class);
    }

    public function getAllUserCategories()
    {
        $categories = $this->categoryService->getAll(auth()->user()->id);
        return response()->json($categories, 200);
    }

    public function create(CreateCategoryRequest $request)
    {
        $owner = new User;
        $owner->setId(auth()->user()->id);

        $category = new Category;
        $category->setName($request['name']);
        $category->setOwner($owner);;
        return response()->json($this->categoryService->create($category), 201);
    }

    public function delete(DeleteCategoryRequest $request)
    {
        $this->categoryService->delete($request['id']);
        return Response::make("", 204);
    }
}
