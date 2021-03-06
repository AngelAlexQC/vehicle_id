@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('records.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.registros.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.registros.inputs.parking_id')</h5>
                    <span>{{ $record->parking_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.registros.inputs.vehicle_id')</h5>
                    <span>{{ $record->vehicle_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.registros.inputs.user_id')</h5>
                    <span>{{ optional($record->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.registros.inputs.driver_id')</h5>
                    <span>{{ optional($record->driver)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('records.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Record::class)
                <a href="{{ route('records.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
