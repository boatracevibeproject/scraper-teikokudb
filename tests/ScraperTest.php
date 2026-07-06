<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB\Tests;

use BVP\Scraper\TeikokuDB\Scraper;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author shimomo
 */
final class ScraperTest extends TestCase
{
    /**
     * @param list<non-empty-string> $arguments
     * @param array<non-negative-int, array<non-empty-string, mixed>> $expected
     * @return void
     */
    #[Test]
    #[DataProviderExternal(ScraperDataProvider::class, 'scrapeLadyRacersProvider')]
    public function scrapeLadyRacers(array $arguments, array $expected): void
    {
        $html = file_get_contents(...$arguments);

        $mockHttpClient = new MockHttpClient(new MockResponse($html, [
            'response_headers' => ['content-type' => 'text/html; charset=UTF-8'],
        ]));

        $httpBrowser = new HttpBrowser($mockHttpClient);

        $this->assertSame($expected, Scraper::scrapeLadyRacers(null, $httpBrowser));
    }
}
