<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;
use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;

class VehiclesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Vehicle::class);

        $search = $request->get('search', '');

        $vehicles = Vehicle::search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    /**
     * @param \App\Http\Requests\VehicleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleStoreRequest $request)
    {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validated();

        $vehicle = Vehicle::create($validated);

        return new VehicleResource($vehicle);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return new VehicleResource($vehicle);
    }

    /**
     * @param \App\Http\Requests\VehicleUpdateRequest $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $validated = $request->validated();

        $vehicle->update($validated);

        return new VehicleResource($vehicle);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);

        $vehicle->delete();

        return response()->noContent();
    }
}
