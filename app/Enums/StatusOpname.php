<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusOpname extends Enum
{
    const APPROVED  = 'APPROVED';
    const REJECTED  = 'REJECTED';
    const WAITING   = 'WAITING';

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::APPROVED) {
            $result = 'APPROVED';
        } elseif ($value === self::REJECTED) {
            $result = 'REJECTED';
        } elseif ($value === self::WAITING) {
            $result = 'WAITING';
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
