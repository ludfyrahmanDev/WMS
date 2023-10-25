<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationType extends Enum
{
    const STOCK_OPNAME  = 'STOCK_OPNAME';
    const PRODUCT       = 'PRODUCT';
    const KAS           = 'KAS';
}
