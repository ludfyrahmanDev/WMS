<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DraftPublishedStatus extends Enum
{
    const PUBLISHED = 'PUBLISHED';
    const DRAFT     = 'DRAFT';


    public static function getDescription($value): string
    {
        $result = '';
        if ($value === self::PUBLISHED) {
            $result = 'PUBLISHED';
        } elseif ($value === self::DRAFT) {
            $result = 'DRAFT';
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
