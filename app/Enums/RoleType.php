<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleType extends Enum
{
    const SUPERADMIN    = "Super Admin";
    const MANAGER       = "Manager";
    const EMPLOYEE      = "Employee";

    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::SUPERADMIN) {
            $result = 'Super Admin';
        } elseif ($value === self::MANAGER) {
            $result = 'Store Manager';
        } elseif ($value === self::EMPLOYEE) {
            $result = 'Employee';
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
