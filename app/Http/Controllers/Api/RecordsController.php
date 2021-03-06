<?php

namespace App\Http\Controllers\Api;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecordResource;
use App\Http\Resources\RecordCollection;
use App\Http\Requests\RecordStoreRequest;
use App\Http\Requests\RecordUpdateRequest;

class RecordsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Record::class);

        $search = $request->get('search', '');

        $records = Record::search($search)
            ->latest()
            ->paginate();

        return new RecordCollection($records);
    }

    /**
     * @param \App\Http\Requests\RecordStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecordStoreRequest $request)
    {
        $this->authorize('create', Record::class);

        $validated = $request->validated();

        $record = Record::create($validated);

        return new RecordResource($record);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Record $record)
    {
        $this->authorize('view', $record);

        return new RecordResource($record);
    }

    /**
     * @param \App\Http\Requests\RecordUpdateRequest $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(RecordUpdateRequest $request, Record $record)
    {
        $this->authorize('update', $record);

        $validated = $request->validated();

        $record->update($validated);

        return new RecordResource($record);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Record $record)
    {
        $this->authorize('delete', $record);

        $record->delete();

        return response()->noContent();
    }
}
