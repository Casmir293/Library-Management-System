<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Filters\v1\BookFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\v1\BookCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the books resource.
     */
    public function index(Request $request)
    {
        $filter  = new BookFilter();
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) {
            return new BookCollection(Book::paginate());
        } else {
            $books = Book::where($queryItems)->paginate();
            return new BookCollection($books->appends($request->query()));
        }
    }

    /**
     * Store a newly created book resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //
    }

    /**
     * Display the specified book resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified book resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified book resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
