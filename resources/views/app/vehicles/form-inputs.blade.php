@php $editing = isset($vehicle) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="owner_id" label="Propietario" required>
            @php $selected = old('owner_id', ($editing ? $vehicle->owner_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Driver</option>
            @foreach($drivers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="brand"
            label="Marca"
            value="{{ old('brand', ($editing ? $vehicle->brand : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="model"
            label="Model"
            value="{{ old('model', ($editing ? $vehicle->model : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="plate"
            label="Placa"
            value="{{ old('plate', ($editing ? $vehicle->plate : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="registration"
            label="Matrrícula"
            value="{{ old('registration', ($editing ? $vehicle->registration : '')) }}"
            maxlength="10"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <label for="photo">
            Foto
        </label>
        <br>
        <input
            type="file"
            name="photo"
            label="Foto"
            class="form-group"
            id="photo"
            accept="image/*"
            maxlength="255"
            required
        ></input>
    </x-inputs.group>
    <!-- Photo preview -->
    <x-inputs.group class="col-sm-12 col-lg-6">
        <label for="photo">
            Foto
        </label>
        <br>
        <img
            src="{{ $vehicle->photoURL?$vehicle->photoURL : 'https://via.placeholder.com/200'}}"
            alt="Foto"
            class="img-thumbnail"
            width="200"
            height="200"
        ></img>
    </x-inputs.group>
</div>
