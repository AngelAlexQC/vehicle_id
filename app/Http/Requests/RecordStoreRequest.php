<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordStoreRequest extends FormRequest
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
            'parking_id' => ['nullable', 'max:255'],
            'vehicle_id' => ['nullable', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
        ];
    }
}
