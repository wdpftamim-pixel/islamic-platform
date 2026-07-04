<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        return [
            'parent_id' => ['nullable', 'exists:categories,id'],

            'name' => ['required', 'string', 'max:255'],

            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],

            'description' => ['nullable', 'string'],

            'is_active' => ['boolean'],

            'is_featured' => ['boolean'],

            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
