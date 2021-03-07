<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => ['required', 'exists:drivers,id'],
            'brand' => ['required', 'max:255', 'string'],
            'model' => ['required', 'max:255', 'string'],
            'plate' => ['required', 'unique:vehicles', 'max:255', 'string'],
            'registration' => [
                'required',
                'unique:vehicles',
                'max:255',
                'string',
            ],
        ];
    }
}
