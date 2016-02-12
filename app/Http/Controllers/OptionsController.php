<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Option;

class OptionsController extends Controller
{
    public function index()
    {
        $options = Option::all();
        view()->share('options', $options);

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
}
