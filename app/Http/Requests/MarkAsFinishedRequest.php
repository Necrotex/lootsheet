<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class MarkAsFinishedRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payout' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'payout.min' => 'Must be a positive number above 1.',
        ];
    }
}
