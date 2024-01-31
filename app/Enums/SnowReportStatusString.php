<?php

namespace App\Enums;

enum SnowReportStatusString: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case IDLE = 'idle';
    case MAINTENANCE = 'maintenance';

    public function toGreek(): string
    {
        return match ($this) {
            self::OPEN => 'Ανοιχτό',
            self::CLOSED => 'Κλειστό',
            self::IDLE => 'Σε αναμονή',
            self::MAINTENANCE => '',
        };
    }

    public function toTailwindClass(): string
    {
        return match ($this) {
            self::OPEN => 'bg-green-200',
            self::CLOSED => 'bg-red-200',
            self::IDLE => 'bg-orange-200',
            self::MAINTENANCE => 'bg-gray-200',
        };
    }

    public function getParentBackgroundClass(): string
    {
        return match ($this) {
            self::OPEN => 'bg-green-100',
            self::CLOSED => 'bg-red-100',
            self::IDLE => 'bg-orange-100',
            self::MAINTENANCE => 'bg-gray-100',
        };
    }

    public function getChildTextClass(): string
    {
        return match ($this) {
            self::OPEN => 'text-green-700',
            self::CLOSED => 'text-red-700',
            self::IDLE => 'text-orange-700',
            self::MAINTENANCE => 'text-gray-700',
        };
    }

    public function getBorderClass(): string
    {
        return match ($this) {
            self::OPEN => 'border-green-500',
            self::CLOSED => 'border-red-500',
            self::IDLE => 'border-orange-500',
            self::MAINTENANCE => 'border-gray-500',
        };
    }
}
