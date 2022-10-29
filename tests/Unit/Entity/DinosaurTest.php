<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Dinosaur;
use App\Enum\HealthStatus;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function testCanGetAndSetData(): void
    {
        $dino = new Dinosaur(
            name: 'Big Eaty',
            genus: 'Tyrannosaurus',
            length: 15,
            enclosure: 'Paddock A',
        );

        self::assertSame('Big Eaty', $dino->getName());
        self::assertSame('Tyrannosaurus', $dino->getGenus());
        self::assertSame(15, $dino->getLength());
        self::assertSame('Paddock A', $dino->getEnclosure());
    }

    /**
     * @dataProvider sizeDescriptionProvider
     */
    public function testDinoHasCorrectSizeDescriptionFromLength(int $length, string $expectedSize): void
    {
        $dino = new Dinosaur(name: 'Big Eaty', length: $length);

        self::assertSame($expectedSize, $dino->getSizeDescription(), 'This is supposed to be a large Dinosaur');
    }

    public function sizeDescriptionProvider(): \Generator
    {
        yield '10 meter Large Dino' => [10, 'Large'];
        yield '5 meter Medium Dino' => [5, 'Medium'];
        yield '4 meter Small Dino' => [4, 'Small'];
    }

    public function testIsAcceptingVisitorsByDefault(): void
    {
        $dino = new Dinosaur('Dennis');

        self::assertTrue($dino->isAcceptingVisitors());
    }

    public function testIsNotAcceptingVisitorsIfSick(): void
    {
        $dino = new Dinosaur(name: 'Bumpy');

        $dino->setHealth(HealthStatus::SICK);

        self::assertFalse($dino->isAcceptingVisitors());
    }
}
