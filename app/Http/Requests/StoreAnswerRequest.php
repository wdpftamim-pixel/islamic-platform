<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [

            'question_id' => [

                'required',

                'exists:questions,id',

            ],

            'content' => [

                'required',

                'string',

                'min:20',

            ],

        ];
    }
}
