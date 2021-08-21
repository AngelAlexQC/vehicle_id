@extends('layouts.app') @section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between">
                <h4 class="card-title">@lang('crud.registros.index_title')</h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{--
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\Record::class)
                        <a
                            href="{{ route('records.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                    --}}
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th>@lang('crud.registros.inputs.parking_id')</th>
                            <th>@lang('crud.registros.inputs.vehicle_id')</th>
                            <th>@lang('crud.registros.inputs.user_id')</th>
                            <th>@lang('crud.registros.inputs.driver_id')</th>
                            <th>Hora de Registro</th>
                            {{--
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                            --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                        <tr>
                            <td>{{ $record->parking ?? '-' }}</td>
                            <td>{{ $record->vehicle->plate ?? '-' }}</td>
                            <td>{{ optional($record->user)->name ?? '-' }}</td>
                            <td>
                                {{ optional($record->driver)->name ?? '-' }}
                            </td>
                            <td>
                                {{ $record->created_at }}
                            </td>
                            {{--
                            <td class="text-center" style="width: 134px">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $record)
                                    <a
                                        href="{{
                                            route('records.edit', $record)
                                        }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $record)
                                    <a
                                        href="{{
                                            route('records.show', $record)
                                        }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $record)
                                    <form
                                        action="{{
                                            route('records.destroy', $record)
                                        }}"
                                        method="POST"
                                        onsubmit=`return confirm('{{
                                            __('crud.common.are_you_sure')
                                        }}')'
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                            --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">{!! $records->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
