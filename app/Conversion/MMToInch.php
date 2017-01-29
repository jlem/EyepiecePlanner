<?php namespace EPP\Conversion;

class MMToInch
{
    const RATE = 25.3;
    const EXACT = 1;
    const NEAREST_HALF = 2;
    const NEAREST_QUARTER = 4;

    public static function convert($value, $precision)
    {
        return round(floatval($value / self::RATE) * $precision) / $precision;
    }
}