<?php

namespace App\Enums;

enum SnowReportLiftStatus: string
{
    case OPEN = 'green';
    case CLOSED = 'red';
    case IDLE = 'orange';

    public function toStatusString(): string
    {
        return match ($this) {
            self::OPEN => 'open',
            self::CLOSED => 'closed',
            self::IDLE => 'idle',
        };
    }
}
