<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DayName extends Enum
{
    const SUNDAY        = 1;
    const MONDAY        = 2;
    const TUESDAY       = 3;
    const WEDNESDAY     = 4;
    const THURSDAY      = 5;
    const FRIDAY        = 6;
    const SATURDAY      = 7;

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::SUNDAY) {
            $result = 'Ahad';
        } elseif ($value === self::MONDAY) {
            $result = 'Senin';
        } elseif ($value === self::TUESDAY) {
            $result = 'Selasa';
        } elseif ($value === self::WEDNESDAY) {
            $result = 'Rabu';
        } elseif ($value === self::THURSDAY) {
            $result = 'Kamis';
        } elseif ($value === self::FRIDAY) {
            $result = 'Jumat';
        } elseif ($value === self::SATURDAY) {
            $result = 'Sabtu';
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
