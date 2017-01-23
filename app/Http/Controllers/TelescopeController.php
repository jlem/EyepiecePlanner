<?php

namespace EPP\Http\Controllers;

use EPP\Eyepiece;
use EPP\Telescope;
use EPP\Http\Validators\TelescopeValidator;
use EPP\TelescopeService;
use Illuminate\Http\Request;
use Auth;

class TelescopeController extends Controller
{
    /**
     * @var TelescopeService
     */
    private $telescopeService;

    public function __construct(TelescopeService $telescopeService)
    {
        $this->telescopeService = $telescopeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->telescopeService->saveCookieTelescopesToDatabase();

        $telescopes = user()->getTelescopes();

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

        // Store telescope information in the database, else store it in a cookie
        if (Auth::check()) {
            Auth::user()->telescopes()->create($input);
            return redirect('/telescope');
        }
        else {
            // Get existing telescopes from cookies and append new telescope data to it
            $telescopes = $request->hasCookie('epp_telescope') ? $request->cookie('epp_telescope') : [];
            $telescopes[] = $input;
            return redirect('/telescope')->cookie('epp_telescope', $telescopes);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $telescopes = user()->getTelescopes();

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

        if ($telescope->getUser()->id !== Auth::user()->id) {
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
        //
    }
}
