<?php namespace EPP\Eyepiece;

use EPP\Manufacturer;
use EPP\ProductLine;
use EPP\Region\Region;
use EPP\Telescope;
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
        'product_line_id',
        'price',
        'region'
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

    public function getProductName()
    {
        return sprintf('%s %s', $this->getManufacturer()->getName(), $this->getProductLine()->getName());
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

    // Magic mutator
    public function setPriceAttribute($value)
    {
        $priceRange = explode('-', $value);

        foreach($priceRange as $key => $price) {
            $priceRange[$key] = number_format(floatval($price), 2);
        }

        $this->attributes['price'] = implode(' - ', $priceRange);
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getRegion()
    {
        return $this->region ? (new Region($this->region))->value() : null;
    }

    public function getRegionLabel()
    {
        return $this->region ? (new Region($this->region))->string('strtoupper') : '';
    }

    public function calculateMagnification(Telescope $telescope)
    {
        return floatval(number_format($telescope->getFocalLength() / $this->getFocalLength(), 2));
    }

    public function calculateTrueFov(Telescope $telescope)
    {
        return floatval(number_format($this->getApparentField() / $this->calculateMagnification($telescope), 2));
    }

    public function calculateExitPupil(Telescope $telescope)
    {
        return floatval(number_format($telescope->getAperture() / $this->calculateMagnification($telescope), 1));
    }

    public function toArray()
    {
        $eyepiece = parent::toArray();
        $eyepiece['price'] = $eyepiece['price'] ?: '';
        $eyepiece['region'] = $this->getRegionLabel();
        return $eyepiece;
    }
}