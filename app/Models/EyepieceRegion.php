<?php

namespace EPP\Models;

use Illuminate\Database\Eloquent\Model;

class EyepieceRegion extends Model
{
    protected $fillable = [
        'eyepiece_id',
        'region_id',
        'price'
    ];
}