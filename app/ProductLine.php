<?php

namespace EPP;

use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    protected $fillable = [
        'name',
        'manufacturer_id'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}
