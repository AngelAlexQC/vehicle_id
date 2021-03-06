<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Requests\DriverStoreRequest;
use App\Http\Requests\DriverUpdateRequest;

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
        $this->authorize('create', Driver::class);

        $validated = $request->validated();

        $driver = Driver::create($validated);

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
    public function update(DriverUpdateRequest $request, Driver $driver)
    {
        $this->authorize('update', $driver);

        $validated = $request->validated();

        $driver->update($validated);

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
