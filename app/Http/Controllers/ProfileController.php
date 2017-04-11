<?php

namespace EPP\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showForm()
    {
        return view('profile.form');
    }

    public function submit(Request $request)
    {
        $input = $request->only(['pupil_size']);
        $rules = ['pupil_size' => 'required|numeric'];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Auth::user()->update($input);

        return redirect()->back();
    }
}
