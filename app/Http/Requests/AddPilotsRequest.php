<?php

namespace App\Http\Requests;

class AddPilotsRequest extends Request
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
            'pilots' => 'required|fleet_composition'
        ];
    }

    public function messages()
    {
        return [
            'pilots.fleet_composition' => 'Wrong format.', //todo: write good error message
        ];
    }
}
