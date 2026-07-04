<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;




class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories($request);

      return $this->successResponse(
            data: CategoryResource::collection($categories),
            message: 'Categories fetched successfully',
            meta: [
            'current_page' => $categories->currentPage(),
            'last_page' => $categories->lastPage(),
            'per_page' => $categories->perPage(),
            'total' => $categories->total(),
            ]
            );


    }
    public function store(StoreCategoryRequest $request): JsonResponse
{
    $category = $this->categoryService->createCategory($request->validated());

   return $this->successResponse(
    data: new CategoryResource($category),
    message: 'Category created successfully',
    status: 201
    );

}
    public function update(
        UpdateCategoryRequest $request,
        Category $category
        ): JsonResponse {
        $updatedCategory = $this->categoryService
        ->updateCategory($category, $request->validated());

        return $this->successResponse(
            data: new CategoryResource($updatedCategory),
            message: 'Category updated successfully'
        );


    }
    public function destroy(Category $category): JsonResponse
    {
    $this->categoryService->deleteCategory($category);

    return $this->successResponse(
        message: 'Category deleted successfully'
    );
    }



}
