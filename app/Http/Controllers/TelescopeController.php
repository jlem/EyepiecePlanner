<?php

namespace EPP\Http\Controllers;

use EPP\Eyepiece;
use EPP\Telescope;
use EPP\Http\Validators\TelescopeValidator;
use Illuminate\Http\Request;
use Auth;

class TelescopeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $telescopes = Auth::user()->getTelescopes();

        return view('telescope.index', compact('telescopes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('telescope.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'aperture', 'focal_length']);

        $validator = TelescopeValidator::make($input);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Auth::user()->telescopes()->create($input);

        return redirect('/telescope');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $telescopes = Auth::user()->getTelescopes();

        $selectedTelescope = Telescope::find($id);

        $eyepieces = Eyepiece::with('productLine', 'manufacturer')
            ->orderBy('manufacturer_id', 'ASC')
            ->orderBy('product_line_id', 'ASC')
            ->orderBy('focal_length', 'ASC')
            ->get();

        return view('telescope.show', compact('selectedTelescope', 'telescopes', 'eyepieces'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $telescope = Telescope::find($id);

        return view('telescope.edit', compact('telescope'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Verify ownership
        $telescope = Telescope::find($id);

        if ($telescope->user_id !== Auth::user()->id) {
            abort(401);
        }

        $input = $request->only(['name', 'aperture', 'focal_length']);

        $telescope->update($input);

        return redirect('/telescope');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verify ownership
        $telescope = Telescope::find($id);

        if (!$telescope || $telescope->user_id !== Auth::user()->id) {
            abort(401);
        }

        $telescope->delete();

        return redirect('/telescope');
    }
}
