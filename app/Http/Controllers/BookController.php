<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class BookController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = Book::filters();
        $users = QueryBuilder::for(Book::class)
            ->select('id', 'title', 'published')
            ->allowedFilters(getAllowedFilters($filters))
            ->paginate(10);

        $filters = collect(['filters' => $filters]);
        $data = $filters->merge($users);

        return response(['books' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();

        $book = Book::create($data);

        return response()->json(['book' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);

        return response()->json(['book' => $book], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        $book = Book::findOrFail($id);
        $data = $request->validated();
        $book->update($data);

        return response()->json(['user' => $book], 200);
    }

    /**
     * Remove the specified resource from storage.  
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted'], 200);
    }
}
