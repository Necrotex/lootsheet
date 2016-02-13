<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
	protected $guard = 'admin';

    public function login(){
	    session(['state' => uniqid()]);

	    $uri = [
		    'response_type' => 'code',
		    'redirect_uri' => route('auth.callback'),
		    'client_id' => config('eve_sso.client_id'),
		    'scope' => '',
		    'state' => session('state')
	    ];

		$request_url = config('eve_sso.url_auth') . '?' . urldecode(http_build_query($uri));

	    return new RedirectResponse($request_url);
    }

	public function callback(Request $request){
		$auth = 'Authorization: Basic ' . base64_encode(config('eve_sso.client_id') . ':' . config('eve_sso.client_secret'));

		$fields = [
			'grant_type' => 'authorization_code',
			'code' => $request->input('code')
		];

		$uri = urldecode(http_build_query($fields));

		$client = new Client();
		$response = $client->request('POST', config('eve_sso.url_token'),
		                 [
			                 'auth' => [config('eve_sso.client_id'), config('eve_sso.client_secret')],
			                 'allow_redirects' => TRUE,
			                 'form_params' => $fields
		                 ]
		);

		$body = $response->getBody();
		$data = json_decode($body->getContents());

		//get character data
		$header = [
			'Authorization' => 'Bearer ' . $data->access_token
		];

		$response = $client->request('GET', config('eve_sso.url_verify'),
		                             [
			                             'headers' => $header,

		                             ]
		);

		$body = $response->getBody();
		$character = json_decode($body->getContents());

		$user = User::firstOrCreate(['character_id' => $character->CharacterID]);
		$user->character_id = $character->CharacterID;
		$user->name = $character->CharacterName;
		$user->character_owner_hash = $character->CharacterOwnerHash;

		if($user->character_id == env('LOOTSHEET_ADMIN_ID')){
			$user->admin = true;
		}

		$user->admin = true; //todo: remove later when deploying

		$user->save();

		Auth::login($user);

		return redirect()->route('home');
	}

	public function logout(Request $request){
		Auth::logout();
		return redirect()->route('home');
	}


}
