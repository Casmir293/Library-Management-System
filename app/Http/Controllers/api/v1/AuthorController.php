<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Author;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AuthorResource;
use App\Http\Requests\v1\UpdateAuthorRequest;
use App\Http\Requests\v1\StoreAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the author resource.
     */
    public function index()
    {
        $authors = Author::paginate();
        return AuthorResource::collection($authors);
    }

    /**
     * Store a newly created author resource in storage (admin/librarian only).
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->all());
        return new AuthorResource($author);
    }

    /**
     * Display the specified author resource.
     */
    public function show(Author $id)
    {
        return new AuthorResource($id);
    }

    /**
     * Update the specified author resource in storage (admin/librarian only).
     */
    public function update(UpdateAuthorRequest $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->update($request->validated());
        return new AuthorResource($author);
    }

    /**
     * Remove the specified author resource from storage (admin only).
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json(['message' => 'Author deleted successfully']);
    }
}
