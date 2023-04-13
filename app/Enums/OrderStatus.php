<?php

namespace App\Enums;

enum OrderStatus: string
{
    use EnumHelper;

    case PENDING   = 'pending';
    case CONFIRMED = 'confirmed';
}
