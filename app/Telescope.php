<?php

namespace EPP;

use Illuminate\Database\Eloquent\Model;

class Telescope extends Model
{
    protected $fillable = [
        'name',
        'aperture',
        'focal_length',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAperture()
    {
        return $this->aperture;
    }

    public function getApertureInches()
    {
        // This sequence does the following:
        // 1. Convert mm to inches
        // 2. Get the float value of this number (which will drop extraneous zeros)
        // 3. By multiplying by four, rounding, and dividing by four, we can get to the nearest 1/4"
        return round(floatval($this->getAperture() / 25.4) * 4) / 4;
    }

    public function getFocalLength()
    {
        return $this->focal_length;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getDescription()
    {
        return sprintf('%s (%s mm x %s mm)', $this->getName(), $this->getAperture(), $this->getFocalLength());
    }
}