<?php

namespace App\Entity;

use App\Enum\HealthStatus;

class Dinosaur
{
    private string $name;
    private string $genus;
    private int $length;
    private string $enclosure;
    private HealthStatus $health = HealthStatus::HEALTHY;

    public function __construct(string $name, string $genus = 'Unknown', int $length = 0, string $enclosure = 'Unknown')
    {
        $this->name = $name;
        $this->genus = $genus;
        $this->length = $length;
        $this->enclosure = $enclosure;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    public function getSizeDescription(): string
    {
        return match (true) {
            $this->length >= 10 => 'Large',
            $this->length >= 5 => 'Medium',
            default => 'Small'
        };
    }

    public function isAcceptingVisitors(): bool
    {
        return $this->health !== HealthStatus::SICK;
    }

    public function acceptingVisitorsLabel(): string
    {
        return $this->health->getLabelAcceptVisitors();
    }

    public function setHealth(HealthStatus $health): void
    {
        $this->health = $health;
    }
}
