<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PurchaseType extends Enum
{
    const FULL          = 'FULL';
    const INSTALLMENT   = 'INSTALLMENT';
    const CONSIGNMENT   = 'CONSIGNMENT';

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::FULL) {
            $result = 'FULL';
        } elseif ($value === self::INSTALLMENT) {
            $result = 'INSTALLMENT';
        } elseif ($value === self::CONSIGNMENT) {
            $result = 'CONSIGNMENT';
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
