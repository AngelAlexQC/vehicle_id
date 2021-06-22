@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="cardm">
                    <div class="card-header">{{ __('Última consulta: ' . Auth::user()->name) }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($record)
                        <div class="d-flex">
                            @if ($record->vehicle):
                            <div class="container text-center">
                                <h5>
                                    Vehículo
                                </h5>
                                <h3>
                                    Placa: {{ $record->vehicle->plate }}
                                </h3>
                                <img src="https://picsum.photos/500" class="rounded" style="width: 15rem;height: 15rem;">
                                <p>
                                <ul style="list-style: none;padding-left: 0">
                                    <li>
                                        <strong>Tel:</strong>&nbsp;{{ $record->driver->phone }}
                                    </li>
                                    <li>
                                        <strong>Email:</strong>&nbsp;{{ $record->driver->email }}
                                    </li>
                                </ul>
                                </p>
                                @endif
                            </div>
                            <div class="container text-center">
                                <h5>
                                    Conductor
                                </h5>
                                <h3>
                                    {{ $record->driver->name }}&nbsp;{{ $record->driver->surname }}
                                </h3>
                                <h5>
                                    Cédula: {{ $record->driver->dni }}
                                </h5>
                                <img src="https://picsum.photos/500" class="rounded" style="width: 15rem;height: 15rem;">
                                <p>
                                <ul style="list-style: none;padding-left: 0">
                                    <li>
                                        <strong>Tel:</strong>&nbsp;{{ $record->driver->phone }}
                                    </li>
                                    <li>
                                        <strong>Email:</strong>&nbsp;{{ $record->driver->email }}
                                    </li>
                                </ul>
                                </p>
                            </div>
                        </div>
                        @else
                            Bienvenido...
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
