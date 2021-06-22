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
use App\Models\Record;
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
        $driver = Driver::where('dni', $dni)->with(['vehicles'])->first();

        $this->authorize('view', $driver);

        $record = Record::create([
            'driver_id' => $driver->id,
            'user_id' => $request->user()->id
        ]);

        broadcast(new RecordSaved($record))->toOthers();
        return $this->success(new DriverResource($driver));
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
