<?php

namespace App\Http\Requests;

class CreateSignatureRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //todo: needs real auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sig_paste' => 'required|signature'
        ];
    }

    public function messages()
    {
        return [
            'sig_paste.signature' => 'Wrong format', //todo: write good error message
        ];
    }
}
