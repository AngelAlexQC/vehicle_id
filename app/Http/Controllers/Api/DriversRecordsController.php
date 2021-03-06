<?php

namespace App\Http\Controllers\Api;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecordResource;
use App\Http\Resources\RecordCollection;

class DriversRecordsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Driver $driver)
    {
        $this->authorize('view', $driver);

        $search = $request->get('search', '');

        $records = $driver
            ->records()
            ->search($search)
            ->latest()
            ->paginate();

        return new RecordCollection($records);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Driver $driver)
    {
        $this->authorize('create', Record::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'parking_id' => ['required', 'exists:parkings,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
        ]);

        $record = $driver->records()->create($validated);

        return new RecordResource($record);
    }
}
