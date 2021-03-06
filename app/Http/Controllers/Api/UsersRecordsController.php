<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecordResource;
use App\Http\Resources\RecordCollection;

class UsersRecordsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $records = $user
            ->records()
            ->search($search)
            ->latest()
            ->paginate();

        return new RecordCollection($records);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Record::class);

        $validated = $request->validate([
            'parking_id' => ['required', 'exists:parkings,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
        ]);

        $record = $user->records()->create($validated);

        return new RecordResource($record);
    }
}
