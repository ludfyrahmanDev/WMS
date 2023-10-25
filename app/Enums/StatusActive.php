<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusActive extends Enum
{
    const ACTIVE    = 'active';
    const INACTIVE  = 'inactive';


    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::ACTIVE) {
            $result = 'active';
        } elseif ($value === self::INACTIVE) {
            $result = 'inactive';
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
