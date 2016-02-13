<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        view()->share('users', $users);

        return $this->view('admin.users');
    }

    public function ajaxUsers(Request $request)
    {
        $users = User::where('name', 'LIKE', '%' . $request->input('data') .'%')->get();

        return response()->json($users->toJson());
    }

    public function userInfo(Request $request, $id)
    {
        $user = User::find($id);

        return view('modals.admin_user_info')->with('user', $user);
    }


    public function promoteUser(Request $request, $id){

        if($request->input('_action') == 'promote_user'){
            $user = User::find($id);
            $user->admin = true;
            $user->timestamps = false; //don't update the timestamps
            $user->save();
        }

        return redirect()->route('admin.index');
    }

    public function demoteUser(Request $request, $id){

        if($request->input('_action') == 'demote_user'){
            $user = User::find($id);
            $user->admin = false;
            $user->timestamps = false; //don't update the timestamps
            $user->save();
        }

        return redirect()->route('admin.index');
    }
}
