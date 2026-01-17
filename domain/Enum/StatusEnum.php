<?php

namespace Domain\Enum;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';

    public static function getAllStatuses(): array
    {
        return self::cases();
    }
}