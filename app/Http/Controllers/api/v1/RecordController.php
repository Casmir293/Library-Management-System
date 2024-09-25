<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\RecordResource;

class RecordController extends Controller
{
    /**
     * Display a listing of the borrow records.
     */
    public function index()
    {
        $records = Record::with('book', 'user')->paginate();
        return RecordResource::collection($records);
    }

    /**
     * Display the specified borrow record.
     */
    public function show($id)
    {
        $record = Record::with('book', 'user')->findOrFail($id);
        return new RecordResource($record);
    }
}
