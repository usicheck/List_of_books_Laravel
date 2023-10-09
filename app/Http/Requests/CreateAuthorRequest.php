<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAuthorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'surname' => ['required', 'string', 'min:3', 'max:100'],
            'father_name' => ['nullable', 'string', 'max:100'],
        ];
    }
}
