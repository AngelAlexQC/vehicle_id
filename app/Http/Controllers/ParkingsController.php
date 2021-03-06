<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;
use App\Http\Requests\ParkingStoreRequest;
use App\Http\Requests\ParkingUpdateRequest;

class ParkingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Parking::class);

        $search = $request->get('search', '');

        $parkings = Parking::search($search)
            ->latest()
            ->paginate(5);

        return view('app.parkings.index', compact('parkings', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Parking::class);

        return view('app.parkings.create');
    }

    /**
     * @param \App\Http\Requests\ParkingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParkingStoreRequest $request)
    {
        $this->authorize('create', Parking::class);

        $validated = $request->validated();

        $parking = Parking::create($validated);

        return redirect()
            ->route('parkings.edit', $parking)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Parking $parking)
    {
        $this->authorize('view', $parking);

        return view('app.parkings.show', compact('parking'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Parking $parking)
    {
        $this->authorize('update', $parking);

        return view('app.parkings.edit', compact('parking'));
    }

    /**
     * @param \App\Http\Requests\ParkingUpdateRequest $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function update(ParkingUpdateRequest $request, Parking $parking)
    {
        $this->authorize('update', $parking);

        $validated = $request->validated();

        $parking->update($validated);

        return redirect()
            ->route('parkings.edit', $parking)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Parking $parking)
    {
        $this->authorize('delete', $parking);

        $parking->delete();

        return redirect()
            ->route('parkings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
