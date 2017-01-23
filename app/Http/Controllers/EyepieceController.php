<?php

namespace EPP\Http\Controllers;

use EPP\Eyepiece;
use EPP\Manufacturer;
use EPP\ProductLine;
use Illuminate\Http\Request;
use Auth;
use Session;

class EyepieceController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eyepieces = Eyepiece::with(['productLine', 'manufacturer'])
            ->join('product_lines', 'product_lines.id', '=', 'eyepieces.product_line_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'eyepieces.manufacturer_id')
            ->select('eyepieces.*')
            ->orderBy('manufacturers.name', 'ASC')
            ->orderBy('product_lines.name', 'ASC')
            ->orderBy('eyepieces.focal_length', 'ASC')
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
        $manufacturers = Manufacturer::with(['productLines' => function ($query) {
            $query->orderby('name', 'ASC');
        }])
            ->orderBy('name', 'ASC')
            ->get();

        return view('eyepiece.create', compact('manufacturers'));
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

        $input['manufacturer_id'] = ProductLine::find($input['product_line_id'])->manufacturer_id;

        $input = array_filter($input);

        Eyepiece::create($input);

        // Preserve session information to add another eyepiece
        if (!empty($request->input('addanother'))) {
            Session::put('add-eyepiece', [
                'product_line_id' => intval($input['product_line_id']),
                'apparent_field' => floatval($input['apparent_field']),
            ]);
            return redirect('/eyepiece/create');
        } else {
            Session::forget('add-eyepiece');
        }

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

        $telescopes = user()->getTelescopes();

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

        $manufacturers = Manufacturer::with(['productLines' => function ($query) {
            $query->orderby('name', 'ASC');
        }])
            ->orderBy('name', 'ASC')
            ->get();

        return view('eyepiece.edit', compact('eyepiece', 'manufacturers'));
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

        $input['manufacturer_id'] = ProductLine::find($input['product_line_id'])->manufacturer_id;

        $input = array_filter($input);

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
