<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{

    public function index(Request $request)
    {
        $query = $this->applyFilters($request, Author::query());
        $sortBy = $request->session()->get('sortBy', 'random');
        $perPage = 15;

        if ($sortBy === 'random') {
            $authors = $query->inRandomOrder()->paginate($perPage);
        } else {
            $authors = $query->orderBy('surname')->paginate($perPage);
        }

        $authors->appends(['sort_by' => $sortBy]);

        return view('authors.index', compact('authors'));
    }


    public function applyFilters(Request $request, $query)
    {
        $sortBy = $request->session()->get('sortBy', 'random');

        if ($request->has('surname')) {
            $query->where('surname', 'like', '%' . $request->input('surname') . '%');
        }

        if ($sortBy == 'random') {
            $query->orderByRaw('RAND()');
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $request->session()->put('sortBy', $sortBy);
        }

        if ($sortBy == 'surname') {
            $query->orderBy('surname');
        }

        if ($request->has('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('surname', 'like', $searchTerm);
            });
        }

        return $query;
    }

    public function create()
    {
        return view('authors/create');

    }

    public function store(CreateAuthorRequest $request)
    {
        try {
            $author = Author::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'father_name' => $request->father_name,
            ]);
            return response()->json([
                'message' => 'Author was edit successfully',
                'name' => $request->name,
                'surname' => $request->surname,
                'father_name' => $request->father_name,]);


        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops smth went wrong']);
        }
    }


    public function update(UpdateAuthorRequest $request, $id)

    {
        try {
            $author = Author::findOrFail($id);

            $author->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'father_name' => $request->father_name,
            ]);

            $authors = Author::all();

            return response()->json(['authors' => $authors]);


        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops smth went wrong']);

        }
    }

}
