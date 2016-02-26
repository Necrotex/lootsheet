<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index()
    {
        $options = Option::where('key', '!=', 'allowed_corps')->get();
        $allowed_corps = OPtion::where('key', 'allowed_corps')->get();

        view()->share('options', $options);
        view()->share('allowed_corps', $allowed_corps);

        return $this->view('options.overview');
    }

    public function action(Requests\EditOptionRequest $request, $id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('options.all');
        }

        $option = Option::find($id);

        if (is_null($option)) {
            return redirect()->route('options.all');
        }

        $option->name = $request->input('name');
        $option->value = $request->input('value');
        $option->save();

        return redirect()->route('options.all');
    }

    public function addCorp(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'value' => 'required|numeric',
            ]
        );

        $option = new Option();
        $option->name = $request->name;
        $option->value = $request->value;
        $option->key = 'allowed_corps';
        $option->type = 'meta';

        $option->save();

        return back();
    }

    public function removeCorp(Request $request, $id)
    {
        if($request->_action != 'remove_corp')
            return back()->withErrors(['error' => 'Wrong action!']);

        $option = Option::findOrFail($id);
        $option->delete();

        return back();
    }
}
