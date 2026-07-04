<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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

            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:articles,slug',
            ],

            'content' => [
                'required',
                'string',
            ],

            'excerpt' => [
                'nullable',
                'string',
            ],

           'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                ],

            'is_published' => [
                'boolean',
            ],

            'is_featured' => [
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],
        ];
    }
}
