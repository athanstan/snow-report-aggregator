<?php

namespace App\Enums;

enum SnowReportStatusString: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case IDLE = 'idle';
    case MAINTENANCE = 'maintenance';

    public function toTailwindClass(): string
    {
        return match ($this) {
            self::OPEN => 'from-green-200',
            self::CLOSED => 'from-red-200',
            self::IDLE => 'from-orange-200',
            self::MAINTENANCE => 'from-gray-200',
        };
    }
}
