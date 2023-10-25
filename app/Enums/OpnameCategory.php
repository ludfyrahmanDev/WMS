<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OpnameCategory extends Enum
{
    const GOOD          = 'GOOD';
    const EXPIRED       = 'EXPIRED';
    const LOST          = 'LOST';
    const DAMAGED       = 'DAMAGED';


    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::GOOD) {
            $result = 'GOOD';
        } elseif ($value === self::EXPIRED) {
            $result = 'EXPIRED';
        } elseif ($value === self::LOST) {
            $result = 'LOST';
        }elseif ($value === self::DAMAGED) {
            $result = 'DAMAGED';
        }
        return $result;
    }

    public static function asOptions()
    {
        $options = [];
        foreach (self::asSelectArray() as $key => $value) {
            array_push($options, ['value' => $key, 'label' => $value]);
        }
        return $options;
    }
}
