<?php

namespace EPP\Http\Controllers;

use EPP\Domain\Model\Eyepiece\Eyepiece;
use EPP\Domain\Model\Eyepiece\EyepieceRepository;
use EPP\Manufacturer;
use EPP\ProductLine;
use EPP\Region\Region;
use Illuminate\Http\Request;
use Auth;
use Session;

class EyepieceController extends Controller
{

    /**
     * @var \EPP\Domain\Model\Eyepiece\EyepieceRepository
     */
    private $eyepieceRepository;

    public function __construct(EyepieceRepository $eyepieceRepository)
    {
        $this->middleware('admin');
        $this->eyepieceRepository = $eyepieceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eps = $this->eyepieceRepository->getAllAlt();
        return view('eyepiece.index-admin', compact('eps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::strings('ucwords');
        $manufacturers = Manufacturer::with(['productLines' => function ($query) {
            $query->orderby('name', 'ASC');
        }])
            ->orderBy('name', 'ASC')
            ->get();

        return view('eyepiece.create', compact('manufacturers', 'regions'));
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
                'region' => intval($input['region']),
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

        $regions = Region::strings('strtoupper');
        $manufacturers = Manufacturer::with(['productLines' => function ($query) {
            $query->orderby('name', 'ASC');
        }])
            ->orderBy('name', 'ASC')
            ->get();

        return view('eyepiece.edit', compact('eyepiece', 'manufacturers', 'regions'));
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

        foreach($input as $key => $value) {
            if ($value === "") {
                $input[$key] = null;
            }

            if ($key == 'is_discontinued') {
                $input['is_discontinued'] = $value === 'on' ? 1 : 0;
            }
        }

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
