<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentStatus extends Enum
{
    const PAID          = 'PAID';
    const PROCESS       = 'PROCESS';

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::PAID) {
            $result = 'Terbayar';
        } elseif ($value === self::PROCESS) {
            $result = 'Proses';
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
