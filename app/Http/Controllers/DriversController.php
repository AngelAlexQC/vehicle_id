<?php

namespace App\Http\Controllers;

use App\Events\RecordSaved;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Requests\DriverStoreRequest;
use App\Http\Requests\DriverUpdateRequest;
use App\Http\Resources\DriverResource;
use App\Models\Parking;
use App\Models\Record;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

class DriversController extends Controller
{
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
            ->paginate(5);

        return view('app.drivers.index', compact('drivers', 'search'));
    }

    /**
     * Find Driver by DNI
     * Header ['Accept'=>'application/json']
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function findByDNI(Request $request)
    {
        $driver = Driver::where('dni', $request->dni)->orWhere(
            'placas',
            'LIKE',
            '%' . $request->plate . '%'
        )->first();
        $parking = Parking::where('id', $request->parking_id)->first();
        $driver_id = null;
        $parking_id = null;
        if ($driver) {
            $driver_id = $driver->id;
        }
        if ($parking) {
            $parking_id = $parking->id;
        }
        $record = Record::create([
            'dni' => $request->dni,
            'plate' => $request->plate,
            'parking_id' => $request->parking_id,
            'type' => $request->type,
            'driver_id' => $driver_id,
            'parking_id' => $parking_id,
            'user_id' => $request->user()->id
        ]);
        $this->authorize('view', $driver);
        return redirect('home');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Driver::class);

        return view('app.drivers.create');
    }

    /**
     * @param \App\Http\Requests\DriverStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverStoreRequest $request)
    {
        $fileName = $request->file('photo')->store('public/photos');
        $fileName = url(str_replace('public', 'storage', $fileName));
        $this->authorize('create', Driver::class);

        $validated = $request->validated();

        $driver = Driver::create($validated);

        $driver->update([
            'photoURL' => $fileName,
        ]);

        return redirect()
            ->route('drivers.edit', $driver)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Driver $driver)
    {
        $this->authorize('view', $driver);

        return view('app.drivers.show', compact('driver'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Driver $driver)
    {
        $this->authorize('update', $driver);

        return view('app.drivers.edit', compact('driver'));
    }

    /**
     * @param \App\Http\Requests\DriverUpdateRequest $request
     * @param \App\Models\Driver $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $this->authorize('update', $driver);

        $fileName = $request->file('photo')->store('public/photos');
        $fileName = url(str_replace('public', 'storage', $fileName));

        $driver->update([
            'dni' => $request->dni,
            'name' => $request->name,
            'photoURL' => $fileName,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()
            ->route('drivers.edit', $driver)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('drivers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
