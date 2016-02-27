<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Option;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    protected $guard = 'admin';

    public function login()
    {

        session(['state' => uniqid()]);

        $uri = [
            'response_type' => 'code',
            'redirect_uri' => route('auth.callback'),
            'client_id' => config('eve_sso.client_id'),
            'scope' => '',
            'state' => session('state'),
        ];

        $request_url = config('eve_sso.url_auth').'?'.urldecode(http_build_query($uri));

        return new RedirectResponse($request_url);
    }

    public function callback(Request $request)
    {
        $auth = 'Authorization: Basic '.base64_encode(config('eve_sso.client_id').':'.config('eve_sso.client_secret'));

        $fields = [
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
        ];

        $uri = urldecode(http_build_query($fields));

        $client = new Client();
        $response = $client->request(
            'POST',
            config('eve_sso.url_token'),
            [
                'auth' => [config('eve_sso.client_id'), config('eve_sso.client_secret')],
                'allow_redirects' => true,
                'form_params' => $fields,
            ]
        );

        $body = $response->getBody();
        $data = json_decode($body->getContents());

        //get character data
        $header = [
            'Authorization' => 'Bearer '.$data->access_token,
        ];

        $response = $client->request(
            'GET',
            config('eve_sso.url_verify'),
            [
                'headers' => $header,
            ]
        );

        $body = $response->getBody();
        $character = json_decode($body->getContents());

        $xml_api_url = 'https://api.eveonline.com/eve/CharacterAffiliation.xml.aspx?ids='.$character->CharacterID;
        $response = $client->request('GET', $xml_api_url);

        $xml = simplexml_load_string($response->getBody()->getContents());

        if (!isset($xml->result->rowset->row->attributes()["characterID"])) {
		    return redirect()->route('home')->withErrors(['login' => 'Character not valid.']);
        }

        $corp_id = (string)$xml->result->rowset->row->attributes()["corporationID"];
        $allianz_id = (string)$xml->result->rowset->row->attributes()["allianceID"];

        $option = Option::where('key',  'allowed_corps')->where('value', $corp_id)->first();
        $admin = false;

        if ($character->CharacterID == env('LOOTSHEET_ADMIN_ID')) {
            $admin = true;
        }

        if(!$option && !$admin)
            return redirect()->route('home')->withErrors(['login' => 'Your Corporation is not allowed to use this lootsheet!']);

        $user = User::firstOrCreate(['character_id' => $character->CharacterID]);
        $user->character_id = $character->CharacterID;
        $user->name = $character->CharacterName;
        $user->corp_id = $corp_id;
        $user->allianz_id = $allianz_id;
        $user->character_owner_hash = $character->CharacterOwnerHash;
        $user->admin = $admin;
        $user->save();

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }


}
