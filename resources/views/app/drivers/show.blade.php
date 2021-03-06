@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('drivers.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.conductores.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.conductores.inputs.dni')</h5>
                    <span>{{ $driver->dni ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.conductores.inputs.name')</h5>
                    <span>{{ $driver->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.conductores.inputs.surname')</h5>
                    <span>{{ $driver->surname ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.conductores.inputs.email')</h5>
                    <span>{{ $driver->email ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.conductores.inputs.phone')</h5>
                    <span>{{ $driver->phone ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('drivers.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Driver::class)
                <a href="{{ route('drivers.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
