<?php

namespace App\Enum;

enum HealthStatus: string
{
    case HEALTHY = 'Healthy';
    case SICK = 'Sick';
    case HUNGRY = 'Hungry';

    public function getLabelAcceptVisitors(): string
    {
        return match ($this) {
            self::SICK => 'no',
            default => 'yes'
        };
    }
}
