<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class RemoveAuthorController extends Controller
{
    public function __invoke($id)
    {
        $author = Author::findOrFail($id);
        try {
            $author->delete();
            return response()->json(['message' => 'Author was remove successfully']);
        } catch (\Exception $exception) {
            logs()->error($exception);
            return response(status: 422)->json(['message' => 'Oops smth went wrong']);
        }
    }
}
