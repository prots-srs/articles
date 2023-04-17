<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->email == 'prots.srs@gmail.com' ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'publish' => 'nullable',
            'sort' => 'nullable|integer|max_digits:3',
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:5000',
            // 'picture' => 'mimetypes:image/*'
            'picture' => 'image|dimensions:max_width=2048,max_height=1600|max:1024',
            'pictureclear' => 'nullable'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sort.integer' => 'The :attribute field must consist only integer.',
            'picture.image' => 'The :attribute field must be only image.',
            'picture.dimensions' => 'The :attribute field must be max width is 1024, height 768.'
        ];
    }
}