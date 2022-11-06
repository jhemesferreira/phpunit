<?php

namespace App\Tests\Unit\Service;

use App\Enum\HealthStatus;
use App\Service\GithubService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GithubServiceTest extends TestCase
{
    /**
     * @dataProvider dinoNameProvider
     */
    public function testGetHealthReportReturnsCorrectHealthStatusForDino(HealthStatus $expectedStatus, string $dinoName): void
    {
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockResponse = new MockResponse(json_encode([
            [
                'title' => 'Daisy',
                'labels' => [['name' => 'Status: Sick']],
            ],
            [
                'title' => 'Maverick',
                'labels' => [['name' => 'Status: Healthy']],
            ],
        ]));

        $mockHttpClient = new MockHttpClient($mockResponse);

        $service = new GithubService(logger: $this->createMock(LoggerInterface::class), httpClient: $mockHttpClient);

        self::assertSame($expectedStatus, $service->getHealthReport($dinoName));
    }

    public function testExceptionThrownWithUnknownLabel(): void
    {
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockResponse = new MockResponse(json_encode(
            [
                'title' => 'Maverick',
                'labels' => [['name' => 'Status: Drowsy']],
            ],
        ));

        $mockHttpClient = new MockHttpClient($mockResponse);

        $service = new GithubService(logger: $this->createMock(LoggerInterface::class), httpClient: $mockHttpClient);

        /**
         * All of these expect methods are just like the assert methods.
         * The big difference is that they must be called before the action you're testing rather than after
         */
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('Drowsy is an unknown status label!');

        $service->getHealthReport('Maverick');
    }


    public function dinoNameProvider(): \Generator
    {
        yield 'Sick Dino' => [
            HealthStatus::SICK,
            'Daisy',
        ];

        yield 'Healthy Dino' => [
            HealthStatus::HEALTHY,
            'Maverick',
        ];
    }
}
