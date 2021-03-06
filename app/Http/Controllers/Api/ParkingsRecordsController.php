<?php

namespace App\Http\Controllers\Api;

use App\Models\Parking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecordResource;
use App\Http\Resources\RecordCollection;

class ParkingsRecordsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Parking $parking)
    {
        $this->authorize('view', $parking);

        $search = $request->get('search', '');

        $records = $parking
            ->records()
            ->search($search)
            ->latest()
            ->paginate();

        return new RecordCollection($records);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Parking $parking)
    {
        $this->authorize('create', Record::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
        ]);

        $record = $parking->records()->create($validated);

        return new RecordResource($record);
    }
}
