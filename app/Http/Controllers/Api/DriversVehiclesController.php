<?php

namespace App\Http\Controllers\Api;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;

class DriversVehiclesController extends Controller
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

        $vehicles = $driver
            ->vehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Driver $driver)
    {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'brand' => ['required', 'max:255', 'string'],
            'model' => ['required', 'max:255', 'string'],
            'plate' => ['required', 'unique:vehicles', 'max:255', 'string'],
            'registration' => [
                'required',
                'unique:vehicles',
                'max:10',
                'string',
            ],
        ]);

        $vehicle = $driver->vehicles()->create($validated);

        return new VehicleResource($vehicle);
    }
}
