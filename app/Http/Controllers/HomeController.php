<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        if(!Auth::check()){
            return $this->view('home.login');
        }

        $sites = Signature::where('active', true)->get();
        view()->share('sites', $sites);
        return $this->view('home.index');
    }
}
