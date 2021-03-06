@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('parkings.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.parqueaderos.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.parqueaderos.inputs.tag')</h5>
                    <span>{{ $parking->tag ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.parqueaderos.inputs.location')</h5>
                    <span>{{ $parking->location ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('parkings.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Parking::class)
                <a href="{{ route('parkings.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
