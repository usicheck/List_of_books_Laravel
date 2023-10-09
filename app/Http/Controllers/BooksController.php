<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function show($id)
    {
        $book = Book::where('id', $id)->first();
        $authors = Author::all();
        return view('books.show', compact('book', 'authors'));
    }


    public function index(Request $request)
    {
        $query = $this->applyFilters($request, Book::query());

        $books = $query->paginate(15);
        foreach ($books as $book) {
            $book->authors = $book->authors()->get();
        }
        $authors = Author::all();
        return view('books.index', compact('books', 'authors'));
    }

    public function applyFilters(Request $request, $query)
    {
        $sortBy = $request->session()->get('sortBy', 'random');

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($sortBy == 'random') {
            $query->orderByRaw('RAND()');
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $request->session()->put('sortBy', $sortBy);
        }

        if ($sortBy == 'title') {
            $query->orderBy('title');
        }

        if ($request->has('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                    ->orWhereHas('authors', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm)
                            ->orWhere('surname', 'like', $searchTerm);
                    });
            });
        }
        return $query;
    }


    public function update(UpdateBookRequest $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $imagePath = public_path($book->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $currentTimestamp = now()->timestamp;
            $image = $request->file('image');
            $imageName = $currentTimestamp . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/images', $imageName);

            $book->update([
                'title' => $request->title,
                'short_des' => $request->short_des,
                'publication_date' => $request->publication_date,
                'image' => 'storage/images/' . $imageName,
            ]);


            $book->authors()->detach();

            $selectedAuthors = $request->input('authors', []);

            $book->authors()->attach($selectedAuthors);
            return redirect()->route('books.index');


        } catch (\Exception $e) {
            return redirect()->back()->withInput();

        }
    }


    public function store(CreateBookRequest $request)
    {
        try {
            $currentTimestamp = now()->timestamp;

            $image = $request->file('image');
            $imageName = $currentTimestamp . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/images', $imageName);

            $book = Book::create([
                'title' => $request->title,
                'short_des' => $request->short_des ?? null,
                'publication_date' => $request->publication_date,
                'image' => 'storage/images/' . $imageName,
            ]);

            $selectedAuthors = $request->input('authors', []);
            $book->authors()->attach($selectedAuthors);

            return redirect()->route('books.index');


        } catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
    }


    public function delete($id)
    {
        try {
            $book = Book::findOrFail($id);
            $imagePath = public_path($book->image);

            $book->delete();

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            return redirect()->route('books.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }


    }

}
