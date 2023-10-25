<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class FollowUp extends Enum
{
    const RETURN_MONEY       = 'RETURN MONEY';
    const RETURN_PRODUCT     = 'RETURN PRODUCT';
    const DESTROY            = 'DESTROY';


    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::RETURN_MONEY) {
            $result = 'RETURN MONEY';
        } elseif ($value === self::RETURN_PRODUCT) {
            $result = 'RETURN PRODUCT';
        } elseif ($value === self::DESTROY) {
            $result = 'DESTROY';
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
