@php $editing = isset($user) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="dni"
            label="Cédula"
            value="{{ old('dni', ($editing ? $user->dni : '')) }}"
            maxlength="10"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nombre"
            value="{{ old('name', ($editing ? $user->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.email
            name="email"
            label="Correo Electrónico"
            value="{{ old('email', ($editing ? $user->email : '')) }}"
            maxlength="255"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password
            name="password"
            label="Contraseña"
            maxlength="255"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.roles.name')</h4>

        @foreach ($roles as $role)
        <div>
            <x-inputs.checkbox
                id="role{{ $role->id }}"
                name="roles[]"
                label="{{ ucfirst($role->name) }}"
                value="{{ $role->id }}"
                :checked="isset($user) ? $user->hasRole($role) : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
