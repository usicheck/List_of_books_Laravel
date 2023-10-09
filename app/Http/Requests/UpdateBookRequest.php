<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{

    public function rules()
    {
        $bookId = $this->route('id');


        return [

            'title' => ['required', 'string', 'min:3', 'max:400', Rule::unique('books', 'title')->ignore($bookId)],
            'short_des' => ['nullable', 'string', 'max:2500'],
            'image' => ['required', 'image:jpeg,png', 'max:2048'],
            'publication_date' => ['required', 'date'],
            'authors' => ['required', 'array', Rule::exists('authors', 'id')],


        ];
    }
}
