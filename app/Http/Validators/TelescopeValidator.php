<?php

namespace EPP\Http\Validators;

use Illuminate\Support\Facades\Validator;

class TelescopeValidator
{
    public static function make(array $data)
    {
        $rules = [
            'name' => 'required|max:64',
            'aperture' => 'required|numeric|min:1|max:10000',
            'focal_length' => 'required|numeric|min:1|max:150000',
            'max_magnification' => 'required|numeric|min:1'
        ];

        return Validator::make($data, $rules);
    }
}