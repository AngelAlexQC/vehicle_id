@php $editing = isset($record) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="parking_id" label="Parking Id">
            @php $selected = old('parking_id', ($editing ? $record->parking_id : '')) @endphp
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="vehicle_id" label="Vehicle Id">
            @php $selected = old('vehicle_id', ($editing ? $record->vehicle_id : '')) @endphp
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $record->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="driver_id" label="Driver" required>
            @php $selected = old('driver_id', ($editing ? $record->driver_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Driver</option>
            @foreach($drivers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
