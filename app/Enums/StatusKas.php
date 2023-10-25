<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusKas extends Enum
{
    const CREDIT    = 'CREDIT';
    const DEBIT     = 'DEBIT';
    const MODAL     = 'MODAL';

    const CLOSE     = 'CLOSE';
    const OPEN      = 'OPEN';
    const PENDING   = 'PENDING';
    const REJECT    = 'REJECT';

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::CREDIT) {
            $result = 'CREDIT';
        } elseif ($value === self::DEBIT) {
            $result = 'DEBIT';
        } elseif ($value === self::MODAL) {
            $result = 'MODAL';
        }elseif ($value === self::CLOSE) {
            $result = 'CLOSE';
        }elseif ($value === self::OPEN) {
            $result = 'OPEN';
        }elseif ($value === self::PENDING) {
            $result = 'PENDING';
        }elseif ($value === self::REJECT) {
            $result = 'REJECT';
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
