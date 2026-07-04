<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class CategoryService
{
   public function getAllCategories(Request $request)
{
return Category::query()
->with('parent')

    ->when($request->featured, function ($query) {
        $query->where('is_featured', true);
    })

    ->when($request->active, function ($query) {
        $query->where('is_active', true);
    })
    ->when($request->search, function ($query, $search) {
    $query->where('name', 'ILIKE', "%{$search}%");
    })
    ->latest()
    ->paginate(10);

}


   public function createCategory(array $data): Category
    {
        return Category::query()->create($data);
    }
    public function updateCategory(Category $category, array $data): Category
        {
        $category->update($data);
        return $category->refresh();
        }
    public function deleteCategory(Category $category): bool
        {
        return $category->delete();
        }




}
