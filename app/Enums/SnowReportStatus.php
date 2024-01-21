<?php

namespace App\Enums;

enum SnowReportStatus: string
{
    case OPEN = 'green';
    case CLOSED = 'red';
    case IDLE = '#ff8000';
    case MAINTENANCE = 'default';

    public function toStatusString(): string
    {
        return match ($this) {
            self::OPEN => 'open',
            self::CLOSED => 'closed',
            self::IDLE => 'idle',
            self::MAINTENANCE => 'maintenance',
        };
    }
}
