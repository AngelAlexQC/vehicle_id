<?php

namespace App\Http\Controllers;

use App\Exports\RecordsExport;
use App\Models\User;
use App\Models\Record;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Requests\RecordStoreRequest;
use App\Http\Requests\RecordUpdateRequest;
use App\Models\Parking;
use Maatwebsite\Excel\Excel;

class RecordsController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Record::class);

        $search = $request->get('search', '');

        $records = Record::search($search)
            ->latest()
            ->paginate(5);

        return view('app.records.index', compact('records', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Record::class);

        $users = User::pluck('name', 'id');
        $drivers = Driver::pluck('name', 'id');

        return view('app.records.create', compact('users', 'drivers'));
    }

    /**
     * @param \App\Http\Requests\RecordStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecordStoreRequest $request)
    {
        $this->authorize('create', Record::class);

        $validated = $request->validated();

        $record = Record::create($validated);

        return redirect()
            ->route('records.edit', $record)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Record $record)
    {
        $this->authorize('view', $record);

        return view('app.records.show', compact('record'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Record $record)
    {
        $this->authorize('update', $record);

        $users = User::pluck('name', 'id');
        $drivers = Driver::pluck('name', 'id');

        return view('app.records.edit', compact('record', 'users', 'drivers'));
    }

    /**
     * @param \App\Http\Requests\RecordUpdateRequest $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(RecordUpdateRequest $request, Record $record)
    {
        $this->authorize('update', $record);

        $validated = $request->validated();

        $record->update($validated);

        return redirect()
            ->route('records.edit', $record)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Record $record)
    {
        $this->authorize('delete', $record);

        $record->delete();

        return redirect()
            ->route('records.index')
            ->withSuccess(__('crud.common.removed'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function report(Request $request)
    {
        $this->authorize('view-any', Record::class);
        $type = $request->type;
        $from = $request->from;
        $to = $request->to;
        $search = $request->get('search', '');
        $parking_id = $request->parking_id;
        $records = Record::all();
        $parkings = Parking::all();
        if ($type) {
            $records = $records->where('type', $request->get('type'));
        }
        if ($from) {
            $records = $records->where('created_at', '>=', $request->from);
        }
        if ($to) {
            $records = $records->where('created_at', '<=', $request->to . ' 23:59:59');
        }
        if ($parking_id) {
            $records = $records->where('parking_id', $request->parking_id);
        }
        if ($search) {
            // Search in all of the fields of drivers
            $drivers = Driver::where('name', 'LIKE', '%' . $search . '%')->orWhere('surname', 'LIKE', '%' . $search . '%')->orWhere('placas', 'LIKE', '%' . $search . '%')
                ->orWhere('dni', 'LIKE', '%' . $search . '%')->get();
            $records = $records->whereIn('driver_id', $drivers->pluck('id'));
        }

        return view('reports', compact(
            'records',
            'parkings',
            'parking_id',
            'type',
            'from',
            'to',
            'search'
        ));
    }

    /**
     * Export to excel
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Request $request)
    {
        $this->authorize('view-any', Record::class);
        $type = $request->type;
        $from = $request->from;
        $to = $request->to;
        $parking_id = $request->parking_id;
        $records = Record::all();
        if ($type) {
            $records = $records->where('type', $request->get('type'));
        }
        if ($from) {
            $records = $records->where('created_at', '>=', $request->from);
        }
        if ($to) {
            $records = $records->where('created_at', '<=', $request->to . ' 23:59:59');
        }
        if ($parking_id) {
            $records = $records->where('parking_id', $request->parking_id);
        }

        // Map the fields
        $records = $records->map(function ($record) {
            return [
                'id' => $record ? $record->id : null,
                'cedula' => $record ? $record->dni : null,
                'placa' => $record ? $record->plate : null,
                'driver_id' => $record->driver_id ? $record->driver_id : null,
                'conductor' => $record->driver ? $record->driver->name : null,
                'user_id' => $record->user_id ? $record->user_id : null,
                'usuario' => $record->user ? $record->user->name : null,
                'parking_id' => $record->parking_id ? $record->parking_id : null,
                'parqueadero' => $record->parking ? $record->parking->tag : null,
                'tipo' => $record->type ? $record->type : null,
                'fecha' => $record ? $record->created_at : null,
            ];
        });

        // Add the header
        $records->prepend([
            'id',
            'cedula',
            'placa',
            'driver_id',
            'conductor',
            'user_id',
            'usuario',
            'parking_id',
            'parqueadero',
            'tipo',
            'fecha',
        ]);
        return $this->excel->download(new RecordsExport($records), 'records.xlsx');
    }
}
