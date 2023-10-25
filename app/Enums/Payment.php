<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethod extends Enum
{
    const QRIS      = 'QRIS';
    const KWB       = 'KWB';
    const CASH      = 'CASH';

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::QRIS) {
            $result = 'QRIS';
        } elseif ($value === self::KWB) {
            $result = 'KWB';
        } elseif ($value === self::CASH) {
            $result = 'CASH';
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
