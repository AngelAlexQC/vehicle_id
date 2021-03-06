<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecordResource;
use App\Http\Resources\RecordCollection;

class VehiclesRecordsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $records = $vehicle
            ->records()
            ->search($search)
            ->latest()
            ->paginate();

        return new RecordCollection($records);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $this->authorize('create', Record::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'parking_id' => ['required', 'exists:parkings,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
        ]);

        $record = $vehicle->records()->create($validated);

        return new RecordResource($record);
    }
}
