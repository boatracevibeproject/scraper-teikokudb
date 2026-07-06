<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB\Contracts;

use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
interface TermScraper
{
    /**
     * @param non-negative-int $term
     * @param ?\Symfony\Component\BrowserKit\HttpBrowser $httpBrowser
     * @return array<non-negative-int, array<non-empty-string, mixed>>
     */
    public static function scrape(int $term, ?HttpBrowser $httpBrowser = null): array;
}
