<?php

namespace App\Enum;

enum HealthStatus: string
{
    case HEALTHY = 'Healthy';
    case SICK = 'Sick';

    public function getLabelAcceptVisitors(): string
    {
        return match ($this) {
            self::HEALTHY => 'yes',
            default => 'no'
        };
    }
}
