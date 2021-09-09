@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="cardm">
                <div class="card-header">{{ __('Última consulta: ' . Auth::user()->name) }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col col-12">
                            <form action="{{route('drivers.vehicles.find')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dni">Buscar Cédula</label>
                                            <input type="text" class="form-control" name="dni" id="dni"
                                                aria-describedby="cedulaHelp" placeholder="Cédula">
                                            <small id="cedulaHelp" class="form-text text-muted">
                                                Ingrese el número de cédula sin guiones
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="plate">Buscar Placa</label>
                                            <input type="text" class="form-control" name="plate" id="plate"
                                                aria-describedby="plateHelp" placeholder="XYZ1314">
                                            <small id="plateHelp" class="form-text text-muted">
                                                Ingrese la placa sin guiones
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="type">Tipo de consulta</label>
                                            <select class="form-control" name="type" id="type" required>
                                                <option>Entrada</option>
                                                <option>Salida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="parking">Parqueadero</label>
                                            <select class="form-control" name="parking" id="parking" required>
                                                @foreach ($parkings as $parking)
                                                <option value="{{$parking->id}}">{{$parking->tag}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <input type="submit" value="Buscar">
                            </form>
                        </div>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if ($record)
                    <div class="d-flex">
                        @if ($record->driver)
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
                            <img src="{{ $record->driver->photoURL?$record->driver->photoURL : 'https://via.placeholder.com/200' }}"
                                class="rounded" style="width: 15rem;height: 15rem;">
                            <p>
                            <ul style="list-style: none;padding-left: 0">
                                <li>
                                    <strong>Tel:</strong>&nbsp;{{ $record->driver->phone }}
                                </li>
                                <li>
                                    <strong>Email:</strong>&nbsp;{{ $record->driver->email }}
                                </li>
                                <li>
                                    <strong>Placas:</strong>&nbsp;{{ $record->driver->placas }}
                                </li>
                            </ul>
                            </p>
                        </div>
                        @endif
                        @if ($record->vehicle)
                        <div class="container text-center">
                            <h5>
                                Vehículo
                            </h5>
                            <h3>
                                Placa: {{ $record->vehicle->plate }}
                            </h3>
                            <img src="{{ $record->vehicle->photoURL?$record->vehicle->photoURL : 'https://via.placeholder.com/200' }}"
                                class="rounded" style="width: 15rem;height: 15rem;">
                            <p>
                                @if($record->vehicle->owner)
                                Propietario: <br> {{
                                    $record->vehicle->owner->name ." ".
                                    $record->vehicle->owner->surname
                            }}
                            <ul style="list-style: none;padding-left: 0; margin-top: 0;">
                                @if($record->vehicle->owner->phone)
                                <li>
                                    <strong>Tel:</strong>&nbsp;{{ $record->vehicle->owner->phone }}
                                </li>
                                @endif
                                <li>
                                    <strong>Email:</strong>&nbsp;{{ $record->vehicle->owner->email }}
                                </li>
                            </ul>
                            @endif
                            </p>
                        </div>
                        @endif

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
