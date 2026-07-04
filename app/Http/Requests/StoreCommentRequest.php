<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            'article_id' => [
                'required',
                'exists:articles,id',
            ],

            'parent_id' => [
                'nullable',
                'exists:comments,id',
            ],

            'content' => [
                'required',
                'string',
                'max:2000',
            ],
        ];
    }
}
