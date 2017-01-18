<?php

namespace EPP\Http\Controllers;

use EPP\Eyepiece;
use EPP\Manufacturer;
use EPP\ProductLine;
use Illuminate\Http\Request;
use Auth;

class EyepieceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eyepieces = Eyepiece::with('productLine', 'manufacturer')
            ->orderBy('manufacturer_id', 'ASC')
            ->orderBy('product_line_id', 'ASC')
            ->orderBy('focal_length', 'ASC')
            ->get();

        return view('eyepiece.index', compact('eyepieces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manufacturers = Manufacturer::all();

        $product_lines = ProductLine::all();

        return view('eyepiece.create', compact('manufacturers', 'product_lines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only((new Eyepiece())->getFillable());

        Eyepiece::create($input);

        return redirect('/eyepiece');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eyepiece = Eyepiece::find($id);

        $telescopes = Auth::user()->getTelescopes();

        return view('eyepiece.show', compact('eyepiece', 'telescopes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eyepiece = Eyepiece::find($id);

        $manufacturers = Manufacturer::all();

        $product_lines = ProductLine::all();

        return view('eyepiece.edit', compact('eyepiece', 'manufacturers', 'product_lines'));
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
        $input = $request->only((new Eyepiece())->getFillable());

        Eyepiece::find($id)->update($input);

        return redirect('/eyepiece');
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
