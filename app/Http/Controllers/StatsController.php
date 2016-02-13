<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
	public function index(Request $request){

		$sites = Signature::all();

		return $this->view('stats.index');
	}
}
