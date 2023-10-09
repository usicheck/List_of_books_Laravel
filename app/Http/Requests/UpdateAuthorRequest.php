<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAuthorRequest extends FormRequest
{

    public function rules()
    {
        $authorId = $this->route('id');

        return [
            'name' => ['required', 'string', 'min:1', 'max:100', Rule::unique('authors', 'name')->ignore($authorId)],
            'surname' => ['required', 'string', 'min:3', 'max:100', Rule::unique('authors', 'surname')->ignore($authorId)],
            'father_name' => ['nullable', 'string', 'max:100', Rule::unique('authors', 'father_name')->ignore($authorId)],
        ];
    }
}
