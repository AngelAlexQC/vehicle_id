<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Record;
use App\Models\Driver;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.records.index', compact('records', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Record::class);

        $users = User::pluck('name', 'id');
        $drivers = Driver::pluck('name', 'id');

        return view('app.records.create', compact('users', 'drivers'));
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

        return redirect()
            ->route('records.edit', $record)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Record $record)
    {
        $this->authorize('view', $record);

        return view('app.records.show', compact('record'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Record $record)
    {
        $this->authorize('update', $record);

        $users = User::pluck('name', 'id');
        $drivers = Driver::pluck('name', 'id');

        return view('app.records.edit', compact('record', 'users', 'drivers'));
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

        return redirect()
            ->route('records.edit', $record)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('records.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
