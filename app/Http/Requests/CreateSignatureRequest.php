<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class CreateSignatureRequest extends Request
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
            'sig_paste' => 'required|signature'
        ];
    }

    public function messages()
    {
        return [
            'sig_paste.signature' => 'Sorry, I can not parse this. Please copy and paste the signature again.',
        ];
    }
}
