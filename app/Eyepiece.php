<?php

namespace EPP;

use Illuminate\Database\Eloquent\Model;

class Eyepiece extends Model
{
    protected $fillable = [
        'apparent_field',
        'barrel_size',
        'field_stop',
        'eye_relief',
        'focal_length',
        'manufacturer_id',
        'product_line_id'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function productLine()
    {
        return $this->belongsTo(ProductLine::class);
    }

    public function getID()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return sprintf('%s %smm %s', $this->getManufacturer()->getName(), $this->getFocalLength(), $this->getProductLine()->getName());
    }

    public function getFocalLength()
    {
        return $this->focal_length;
    }

    public function getEyeRelief()
    {
        return $this->eye_relief;
    }

    public function getFieldStop()
    {
        return $this->field_stop;
    }

    public function getBarrelSize()
    {
        return $this->barrel_size;
    }

    public function getApparentField()
    {
        return $this->apparent_field;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function getProductLine()
    {
        return $this->productLine;
    }

    public function calculateMagnification(Telescope $telescope)
    {
        return intval($telescope->getFocalLength() / $this->getFocalLength());
    }

    public function calculateTrueFov(Telescope $telescope)
    {
        return number_format($this->getApparentField() / $this->calculateMagnification($telescope), 2);
    }

    public function calculateExitPupil(Telescope $telescope)
    {
        return number_format($telescope->getAperture() / $this->calculateMagnification($telescope), 1);
    }
}