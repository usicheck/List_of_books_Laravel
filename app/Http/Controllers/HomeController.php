<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;


class HomeController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        $query = Book::query();
        $books = $query->paginate(15);
        foreach ($books as $book) {
            $book->authors = $book->authors()->get();
        }

        return view('home', compact('books'));
    }


}
