<?php

namespace EPP\Http\Controllers;

use EPP\ProductLine;
use EPP\Manufacturer;
use Illuminate\Http\Request;
use Auth;

class ProductLineController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query the manufacturers instead of product lines so that the index can group the product lines by manufacturer
        $manufacturers = Manufacturer::with('productLines')->get();

        return view('product-line.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $manufacturers = Manufacturer::all();

        $selectedManufacturer = intval($request->input('manufacturer'));

        return view('product-line.create', compact('manufacturers', 'selectedManufacturer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'manufacturer_id']);

        ProductLine::create($input);

        return redirect("/manufacturer/{$input['manufacturer_id']}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productLine = ProductLine::find($id);

        return view('product-line.edit', compact('productLine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productLine = ProductLine::find($id);

        return view('product-line.edit', compact('productLine'));
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
        $input = $request->only(['name']);

        ProductLine::find($id)->update($input);

        return redirect('/product-line');
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
