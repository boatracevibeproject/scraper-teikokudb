<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB\Tests\Scrapers;

use BVP\Scraper\TeikokuDB\Scrapers\LadyRacerScraper;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
final class LadyRacerScraperTest extends TestCase
{
    /**
     * @param list<non-negative-int> $arguments
     * @param array<non-negative-int, array<non-empty-string, mixed>> $expected
     * @return void
     */
    #[Test]
    #[DataProviderExternal(LadyRacerScraperDataProvider::class, 'scrapeProvider')]
    public function testScrape(array $arguments, array $expected): void
    {
        $this->assertSame($expected, LadyRacerScraper::scrape(...$arguments));
    }
}
