<?php namespace EPP\Region;

use Jlem\Enum\Enum;

final class Region extends Enum
{
    const US = 1;
    const EU = 2;
    const AU = 3;

    public static function getStrings()
    {
        return [
            self::US => 'us',
            self::EU => 'eu',
            self::AU => 'au'
        ];
    }
}