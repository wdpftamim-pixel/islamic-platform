<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $categoryId = $this->route('category');

        return [
            'parent_id' => ['nullable', 'exists:categories,id'],

            'name' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],

            'description' => ['nullable', 'string'],

            'is_active' => ['boolean'],

            'is_featured' => ['boolean'],

            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
