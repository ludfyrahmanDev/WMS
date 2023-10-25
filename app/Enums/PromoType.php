<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PromoType extends Enum
{
    const DISCOUNT      = 'DISCOUNT';
    const BUNDLING      = 'BUNDLING';
    const REDEEM        = 'REDEEM';
    const FREEN         = 'FREEN';// free N


    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::DISCOUNT) {
            $result = 'CASH';
        }elseif ($value === self::BUNDLING) {
            $result = 'BUNDLING';
        }elseif ($value === self::FREEN) {
            $result = 'FREEN';
        }elseif ($value === self::FREEN) {
            $result = 'FREEN';
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
