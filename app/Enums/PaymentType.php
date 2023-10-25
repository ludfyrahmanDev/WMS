<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentType extends Enum
{
    const CASH      = 'CASH';
    const DIGITAL   = 'DIGITAL';


    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::CASH) {
            $result = 'CASH';
        } elseif ($value === self::DIGITAL) {
            $result = 'DIGITAL';
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
