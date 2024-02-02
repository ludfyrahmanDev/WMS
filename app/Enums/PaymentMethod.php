<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethod extends Enum
{
    const CASH      = 'CASH';
    const TRANSFER      = 'TRANSFER';
    // const KWB       = 'KWB';

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::TRANSFER) {
            $result = 'TRANSFER';
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
