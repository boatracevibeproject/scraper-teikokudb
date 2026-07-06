<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB\Tests;

use BVP\Scraper\TeikokuDB\Scraper;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
final class ScraperTest extends TestCase
{
    /**
     * @param list<non-negative-int> $arguments
     * @param array<non-negative-int, array<non-empty-string, mixed>> $expected
     * @return void
     */
    #[Test]
    #[DataProviderExternal(ScraperDataProvider::class, 'scrapeLadyRacersProvider')]
    public function scrapeLadyRacers(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapeLadyRacers(...$arguments));
    }
}
