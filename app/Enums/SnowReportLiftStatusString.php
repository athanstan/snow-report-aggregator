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

    public function getParentBackgroundClass(): string
    {
        return match ($this) {
            self::OPEN => 'bg-green-100',
            self::CLOSED => 'bg-red-100',
            self::IDLE => 'bg-orange-100',
        };
    }
}
