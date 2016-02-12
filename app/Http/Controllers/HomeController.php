<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $sites = Signature::where('finished', false)->get();
        view()->share('sites', $sites);
        return $this->view('home.index');
    }
}
