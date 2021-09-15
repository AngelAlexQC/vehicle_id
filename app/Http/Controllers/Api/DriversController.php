<?php

namespace App\Http\Controllers\Api;

use App\Events\RecordSaved;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\DriverCollection;
use App\Http\Requests\DriverStoreRequest;
use App\Http\Requests\DriverUpdateRequest;
use App\Models\Parking;
use App\Models\Record;
use App\Models\Vehicle;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class DriversController extends Controller
{
    use ApiResponser;
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Driver::class);

        $search = $request->get('search', '');

        $drivers = Driver::search($search)
            ->latest()
            ->paginate();

        return new DriverCollection($drivers);
    }

    /**
     * @param \App\Http\Requests\DriverStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverStoreRequest $request)
    {
        $this->authorize('create', Driver::class);

        $validated = $request->validated();

        $driver = Driver::create($validated);

        return new DriverResource($driver);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Driver $driver)
    {
        $this->authorize('view', $driver);

        return new DriverResource($driver);
    }

    /**
     * Find Driver by DNI
     * Header ['Accept'=>'application/json']
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function findByDNI(Request $request, $dni)
    {
        $driver = null;
        $parking = Parking::where('id', $request->parking_id)->first();
        // Find by dni if isset

        $driver = Driver::where('dni', $dni)->first();


        // If driver not found find by plate if plate isset
        if (!$driver && $request->get('plate') != null) {
            $driver = Driver::where(
                'placas',
                'LIKE',
                '%' . $request->plate . '%'
            )->first();
        }
        if (!$driver) {
            $record = Record::create([
                'dni' => $request->dni,
                'plate' => $request->plate,
                'parking_id' => $request->parking_id,
                'type' => $request->type,
                'driver_id' => null,
                'parking_id' => $parking->id,
                'user_id' => Auth::user()->id
            ]);
            // Return Json Error
            return $this->error('No se encontró el conductor', 404);
        }
        $record = Record::create([
            'dni' => $request->dni,
            'plate' => $request->plate,
            'parking_id' => $request->parking_id,
            'type' => $request->type,
            'driver_id' => $driver->id,
            'parking_id' => $parking->id,
            'user_id' => Auth::user()->id
        ]);

        broadcast(new RecordSaved($record))->toOthers();
        return $this->success(new DriverResource($record->load([
            'parking', 'user', 'driver'
        ])));
    }

    /**
     * @param \App\Http\Requests\DriverUpdateRequest $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function update(DriverUpdateRequest $request, Driver $driver)
    {
        $this->authorize('update', $driver);

        $validated = $request->validated();

        $driver->update($validated);

        return new DriverResource($driver);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Driver $driver)
    {
        $this->authorize('delete', $driver);

        $driver->delete();

        return response()->noContent();
    }
}
