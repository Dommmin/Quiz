<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'question_text' => [
                'string',
                'required',
            ],
            'code_snippet' => [
                'string',
                'nullable',
            ],
            'answer_explanation' => [
                'string',
                'nullable',
            ],
            'more_info_link' => [
                'url',
                'nullable',
            ],
            'question_options' => [
                'required',
                'array',
            ],
            'question_options.*.option' => [
                'required',
                'string',
            ],
        ];
    }
}
