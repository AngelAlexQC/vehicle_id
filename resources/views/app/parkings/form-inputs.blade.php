@php $editing = isset($parking) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="tag"
            label="Etiqueta"
            value="{{ old('tag', ($editing ? $parking->tag : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="location"
            label="Ubicación"
            value="{{ old('location', ($editing ? $parking->location : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
