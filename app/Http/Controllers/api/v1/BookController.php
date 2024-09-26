<?php

namespace App\Http\Controllers\api\v1;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Filters\v1\BookFilter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\v1\BookResource;
use App\Http\Requests\v1\StoreBookRequest;
use App\Http\Requests\v1\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the books resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $author = $request->input('author');
        $isbn = $request->input('isbn');

        $filter = new BookFilter();
        $queryItems = $filter->transform($request);

        $query = Book::query();

        if ($title) {
            $query->where('title', 'like', "%$title%");
        }
        if ($author) {
            $query->whereHas('author', function ($q) use ($author) {
                $q->where('name', 'like', "%$author%");
            });
        }
        if ($isbn) {
            $query->where('isbn', $isbn);
        }
        if (count($queryItems) > 0) {
            $query->where($queryItems);
        }

        $books = $query->paginate()->appends($request->query());
        return BookResource::collection($books);
    }

    /**
     * Store a newly created book resource in storage (admin/librarian only).
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->all());
        return new BookResource($book);
    }

    /**
     * Display the specified book resource.
     */
    public function show(Book $id)
    {
        return new BookResource($id);
    }

    /**
     * Update the specified book resource in storage (admin/librarian only).
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->validated());
        return new BookResource($book);
    }

    /**
     * Remove the specified book resource from storage (admin only).
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }

    /**
     * Borrow the specified book resource from storage (member only).
     */
    public function borrowBook($id)
    {
        $book = Book::findOrFail($id);

        if ($book->status !== 'Available') {
            return response()->json(['message' => 'Book is not available for borrowing'], 400);
        }

        Record::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
            'due_at' => Carbon::now()->addDays(14),
        ]);

        $book->update(['status' => 'Borrowed']);
        return response()->json(['message' => 'Book borrowed successfully']);
    }

    /**
     * Return the specified book resource in storage (member only).
     */
    public function returnBook($id)
    {
        $book = Book::findOrFail($id);

        $record = Record::where('book_id', $id)
            ->where('user_id', Auth::id())
            ->whereNull('returned_at')
            ->firstOrFail();

        $record->update([
            'returned_at' => Carbon::now(),
        ]);

        $book->update(['status' => 'Available']);
        return response()->json(['message' => 'Book returned successfully']);
    }
}
