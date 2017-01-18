<?php

namespace EPP;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'name'
    ];

    public function productLines()
    {
        return $this->hasMany(ProductLine::class);
    }

    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProductLines()
    {
        return $this->productLines;
    }
}