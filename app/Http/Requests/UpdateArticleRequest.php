<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
        $articleId = $this->route('article');

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

                Rule::unique('articles', 'slug')
                    ->ignore($articleId),
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
                'string',
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
