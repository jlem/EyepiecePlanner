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
        $telescopeData = $this->getTelescopeDataFromRequest($request);

        /** @var $validator \Illuminate\Validation\Validator */
        $validator = TelescopeValidator::make($telescopeData);

        if ($validator->fails()) {
            return new BadRequest($validator->errors()->toArray());
        }

        $newTelescope = Auth::user()->telescopes()->create($telescopeData);

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

        $telescopeData = $this->getTelescopeDataFromRequest($request);

        /** @var $validator \Illuminate\Validation\Validator */
        $validator = TelescopeValidator::make($telescopeData);

        if ($validator->fails()) {
            return new BadRequest($validator->errors()->toArray());
        }

        $telescope->update($telescopeData);

        return new Ok($telescope);
    }

    private function getTelescopeDataFromRequest(Request $request) {
        $input = $request->only(['name', 'aperture', 'focal_ratio', 'focal_length', 'max_eyepiece_size']);

        return [
            'name' => $input['name'],
            'aperture' => (float)$input['aperture'],
            'focal_ratio' => (float)$input['focal_ratio'],
            'focal_length' => (float)$input['focal_length'],
            'max_eyepiece_size' => $input['max_eyepiece_size']
        ];
    }
}