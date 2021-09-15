@extends('layouts.app')

@section('content')
<div class="container">
    <h4>
        Reporte de Entrada y Salida de Vehículos
    </h4>
    <form method="get">
        <div class="row mb-3">
            <!-- Buscar texto en cualquier campo -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Buscar conductor o placa:</label>
                    <input placeholder="Placa, cédula, nombre o apellido" type="text" class="form-control" id="search"
                        name="search" value="{{$search}}">
                </div>
            </div>
            <!-- Filtrar por entrada o salida -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Entrada o Salida:</label>
                    <select class="form-control" id="type" name="type">
                        <option selected>Todos</option>
                        <option {{$type == 'Entrada' ? 'selected' : ''}}>Entrada</option>
                        <option {{$type == 'Salida' ? 'selected' : ''}}>Salida</option>
                    </select>
                </div>
            </div>
            <!-- Rango de Fecha y Hora -->
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">Rango de Fechas:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Desde:</span>
                        </div>
                        <input type="date" class="form-control" id="from" name="from" value="{{
                            $from != null ? $from : ''
                        }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Hasta:</span>
                        </div>
                        <input type="date" class="form-control" id="to" name="to" value="{{
                            $to != null ? $to : ''
                        }}">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="parking_id">Parqueadero</label>
                    <select class="form-control" name="parking_id" id="parking_id" required>
                        <option selected>Todos</option>
                        @foreach ($parkings as $parking)
                        <option value="{{$parking->id}}" {{$parking->id == $parking_id ? 'selected' : ''}}>
                            {{$parking->tag}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-filter" aria-hidden="true"></i> Filtrar
                </button>
                <!-- Export to excel -->
                <a href="{{route('reports.export', ['type' => $type, 'from' => $from, 'to' => $to, 'parking_id' => $parking_id])}}"
                    target="_blank" class="btn btn-success">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel
                </a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Buscada</th>
                    <th>Placa Buscada</th>
                    <th>Conductor - Placas</th>
                    <th>Parqueadero</th>
                    <th>Entrada o Salida</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->id ? $record->id : '-' }}</td>
                    <td>{{ $record->dni ? $record->dni : '-' }}</td>
                    <td>{{ $record->plate ? $record->plate : '-' }}</td>
                    <td>
                        {{ $record->driver ? $record->driver->name." ".$record->driver->surname  : '-' }}
                        @if ($record->driver)
                        <br>
                        {{ $record->driver ? $record->driver->placas : '' }}
                        @endif
                    </td>
                    <td>{{ $record->parking ? $record->parking->tag : '-' }}</td>
                    <td>{{ $record->type ? $record->type : '-' }}</td>
                    <td>{{ $record->user ? $record->user->name." ".$record->user->surname  : '-' }}</td>
                    <td>{{ $record->created_at ? $record->created_at : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
