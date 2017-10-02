<?php

namespace EPP\Http\Controllers\API;

use EPP\Http\APIResponse;
use EPP\Http\BadRequest;
use EPP\Http\Controllers\Controller;
use EPP\Http\Ok;
use EPP\Http\Validators\TelescopeValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelescopeAPIController extends Controller
{
    /**
     * @param Request $request
     * @return BadRequest|Ok
     */
    public function add(Request $request)
    {
        $input = $request->only(['name', 'aperture', 'focal_ratio', 'max_eyepiece_size']);

        // Convert to correct data types
        $telescope = [
            'name' => $input['name'],
            'aperture' => (float)$input['aperture'],
            'focal_ratio' => (float)$input['focal_ratio'],
            'max_eyepiece_size' => $input['max_eyepiece_size']
        ];

        /** @var $validator \Illuminate\Validation\Validator */
        $validator = TelescopeValidator::make($telescope);

        if ($validator->fails()) {
            return new BadRequest($validator->errors()->toArray());
        }

        $newTelescope = Auth::user()->telescopes()->create($telescope);

        return new Ok($newTelescope);
    }

    /**
     * @param $id
     * @return BadRequest|Ok
     */
    public function remove($id)
    {
        $telescope = Auth::user()->telescopes()->where('id', $id)->first();

        if (!$telescope) {
            return new BadRequest(['Telescope not found']);
        }

        $telescope->delete();

        return new Ok('Telescope deleted');
    }

    /**
     * @param $id
     * @param Request $request
     * @return BadRequest|Ok
     */
    public function update($id, Request $request)
    {
        $telescope = Auth::user()->telescopes()->where('id', $id)->first();

        if (!$telescope) {
            return new BadRequest(['Telescope not found']);
        }

        $telescope->update($request->only(['name', 'focal_length', 'focal_ratio', 'aperture', 'max_eyepiece_size']));

        return new Ok($telescope);
    }
}