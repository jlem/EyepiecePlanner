<?php

namespace EPP\Http\Validators;

use Illuminate\Support\Facades\Validator;

class TelescopeValidator
{
    public static function make(array $data)
    {
        $rules = [
            'name' => 'required|max:64',
            'aperture' => 'required|numeric|min:1|max:100000',
            'focal_ratio' => 'required|numeric|min:1',
            'focal_length' => 'required|numeric|min:1',
            'max_eyepiece_size' => 'required|in:1.25,2,3'
        ];

        return Validator::make($data, $rules);
    }
}