<?php

namespace App\Http\Controllers\Api;

use App\Models\Parking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParkingResource;
use App\Http\Resources\ParkingCollection;
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
            ->paginate();

        return new ParkingCollection($parkings);
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

        return new ParkingResource($parking);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parking $parking
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Parking $parking)
    {
        $this->authorize('view', $parking);

        return new ParkingResource($parking);
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

        return new ParkingResource($parking);
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

        return response()->noContent();
    }
}
