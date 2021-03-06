@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">{{ __('Última consulta: ' . Auth::user()->name) }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container text-center">
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
                </div>
            </div>
        </div>
    </div>
@endsection
