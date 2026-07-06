<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB\Tests\Scrapers;

use BVP\Scraper\TeikokuDB\Scrapers\LadyRacerScraper;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author shimomo
 */
final class LadyRacerScraperTest extends TestCase
{
    /**
     * @param list<non-empty-string> $arguments
     * @param array<non-negative-int, array<non-empty-string, mixed>> $expected
     * @return void
     */
    #[Test]
    #[DataProviderExternal(LadyRacerScraperDataProvider::class, 'scrapeProvider')]
    public function testScrape(array $arguments, array $expected): void
    {
        $html = file_get_contents(...$arguments);

        $mockHttpClient = new MockHttpClient(new MockResponse($html, [
            'response_headers' => ['content-type' => 'text/html; charset=UTF-8'],
        ]));

        $httpBrowser = new HttpBrowser($mockHttpClient);

        $this->assertSame($expected, LadyRacerScraper::scrape(null, $httpBrowser));
    }
}
