<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:400', 'unique:books'],
            'short_des' => ['nullable', 'string', 'max:2500'],
            'image' => ['required', 'image:jpeg,png', 'max:2048'],
            'publication_date' => ['required', 'date'],
        ];
    }
}
