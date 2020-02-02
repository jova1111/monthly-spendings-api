<?php

namespace App\Http\Requests;

use App\Services\CategoryService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class DeleteCategoryRequest extends FormRequest
{
    private $categoryService;

    public function __construct()
    {
        $this->categoryService = App::make(CategoryService::class);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $category = $this->categoryService->get($this->route('id'));
        if (auth()->user()->id != $category->getOwner()->getId()) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
