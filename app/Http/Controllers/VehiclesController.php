<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.vehicles.index', compact('vehicles', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vehicle::class);

        $drivers = Driver::pluck('name', 'id');

        return view('app.vehicles.create', compact('drivers'));
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

        return redirect()
            ->route('vehicles.edit', $vehicle)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return view('app.vehicles.show', compact('vehicle'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $drivers = Driver::pluck('name', 'id');

        return view('app.vehicles.edit', compact('vehicle', 'drivers'));
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

        return redirect()
            ->route('vehicles.edit', $vehicle)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('vehicles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
