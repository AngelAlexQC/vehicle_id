<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverStoreRequest extends FormRequest
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
            'dni' => ['required', 'unique:drivers', 'max:10', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'surname' => ['required', 'max:255', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'unique:drivers', 'max:255', 'string'],
        ];
    }
}
