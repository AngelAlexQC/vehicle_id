@php $editing = isset($driver) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="dni" label="Cédula" value="{{ old('dni', ($editing ? $driver->dni : '')) }}" maxlength="10"
            required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="name" label="Nombres" value="{{ old('name', ($editing ? $driver->name : '')) }}"
            maxlength="255" required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="surname" label="Apellidos" value="{{ old('surname', ($editing ? $driver->surname : '')) }}"
            maxlength="255" required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.email name="email" label="Correo Electrónico"
            value="{{ old('email', ($editing ? $driver->email : '')) }}" maxlength="255" required></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="phone" label="Teléfono" value="{{ old('phone', ($editing ? $driver->phone : '')) }}"
            maxlength="255" required></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="placas" label="Placas" value="{{ old('placas', ($editing ? $driver->placas : '')) }}"
            maxlength="255"></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="col-sm-12 col-lg-6">
        <label for="photo">
            Foto
        </label>
        <br>
        <input type="file" name="photo" label="Foto" class="form-group" id="photo" accept="image/*" maxlength="255"
            required></input>
    </x-inputs.group>
    <!-- Photo preview -->
    <x-inputs.group class="col-sm-12 col-lg-6">
        <label for="photo">
            Foto
        </label>
        <br>
        <img src="{{ old('photo', ($editing ? $driver->photoURL: 'https://via.placeholder.com/200')) }}" alt="Foto"
            class="img-thumbnail" width="200" height="200"></img>
    </x-inputs.group>
</div>
