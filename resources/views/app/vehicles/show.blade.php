@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('vehicles.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.veh_culos.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.veh_culos.inputs.owner_id')</h5>
                    <span>{{ optional($vehicle->owner)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.veh_culos.inputs.brand')</h5>
                    <span>{{ $vehicle->brand ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.veh_culos.inputs.model')</h5>
                    <span>{{ $vehicle->model ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.veh_culos.inputs.plate')</h5>
                    <span>{{ $vehicle->plate ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.veh_culos.inputs.registration')</h5>
                    <span>{{ $vehicle->registration ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('vehicles.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Vehicle::class)
                <a href="{{ route('vehicles.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
