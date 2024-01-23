<?php

namespace App\Enums;

enum SnowReportLiftStatusString: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case IDLE = 'idle';

    public function toTailwindClass(): string
    {
        return match ($this) {
            self::OPEN => 'bg-green-400',
            self::CLOSED => 'bg-red-400',
            self::IDLE => 'bg-orange-400',
        };
    }
}
