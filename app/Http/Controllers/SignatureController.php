<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Sheet;
use App\Models\Signature;

class SignatureController extends Controller
{
    public function index()
    {
        $signature = new Signature;
        view()->share('signature', $signature);

        return $this->view('new_sig.index');
    }

    public function create(Requests\CreateSignatureRequest $request)
    {
        //parse the paste
        $sig = explode("\t", $request->input('sig_paste'));

        $signature = new Signature();
        $signature->sig_id      = $sig[0];
        $signature->sig_type    = $sig[1];
        $signature->sig_group   = $sig[2];
        $signature->sig_name    = $sig[3];
        $signature->creator     = ''; //todo: Auth::user()
        $signature->save();

        $sheet = new Sheet();
        $sheet->site_id = $signature->id;
        $sheet->modifier = 0; //todo: add site modifer from options
        $sheet->save();

        return redirect()->route('sheets.single', ['id' => $signature->id]);
    }
}
