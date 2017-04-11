<?php

namespace EPP;

use Illuminate\Database\Eloquent\Model;
use EPP\Conversion\MMToInch;

class Telescope extends Model
{
    CONST MM_PER_INCH = 25.4;

    protected $fillable = [
        'name',
        'aperture',
        'focal_length',
        'max_magnification',
        'max_eyepiece_size'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setID($id)
    {
        $this->{$this->getKeyName()} = $id;
        return $this;
    }

    public function getID()
    {
        return $this->getKey();
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
        return MMToInch::convert($this->getAperture(), MMToInch::NEAREST_QUARTER);
    }

    public function getFocalLength()
    {
        return $this->focal_length;
    }

    public function getFocalRatio()
    {
        return number_format(($this->getFocalLength() / $this->getAperture()), 1);
    }

    public function getMaxMagnification()
    {
        return $this->max_magnification;
    }

    public function getMaxEyepieceSize()
    {
        return $this->max_eyepiece_size;
    }

    public function calculateMaxMagnification()
    {
        return $this->max_magnification * MMToInch::convert($this->getAperture(), MMToInch::EXACT);
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