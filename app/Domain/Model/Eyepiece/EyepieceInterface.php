<?php

namespace EPP\Domain\Model\Eyepiece;

interface EyepieceInterface
{
    public function getID();

    public function getDescription();

    public function getProductName();

    public function getFocalLength();

    public function getEyeRelief();

    public function getFieldStop();

    public function getBarrelSize();

    public function getApparentField();

    public function getManufacturer();

    public function getProductLine();

    // Magic mutator
    public function setPriceAttribute($value);

    public function getPrice();

    public function getRegion();
}