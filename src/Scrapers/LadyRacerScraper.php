<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB\Scrapers;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use BVP\Scraper\TeikokuDB\Contracts\TermScraper;
use BVP\Scraper\TeikokuDB\Factories\HttpBrowserFactory;
use BVP\Scraper\TeikokuDB\Normalizers\Normalizer;

/**
 * @author shimomo
 */
final class LadyRacerScraper implements TermScraper
{
    /**
     * @var non-empty-string
     */
    private const string BASE_URL = 'https://boatrace-db.net/';

    /**
     * @param ?non-negative-int $term
     * @param ?\Symfony\Component\BrowserKit\HttpBrowser $httpBrowser
     * @return array<non-negative-int, array<non-empty-string, mixed>>
     */
    #[\Override]
    public static function scrape(?int $term = null, ?HttpBrowser $httpBrowser = null): array
    {
        $scraperFormat = '%s/trank/wracer/%s';
        $scraperUrl = sprintf($scraperFormat, self::BASE_URL, $term !== null ? "term/{$term}/" : '');
        $scraper = ($httpBrowser ?? HttpBrowserFactory::create())->request('GET', $scraperUrl);

        return $scraper
            ->filter('table.tTrankRacer > tbody > tr')
            ->each(function (Crawler $element): array {
                $number = $element->filter('td')->eq(0)->text();              // 登録番号
                $name = $element->filter('td')->eq(1)->text();                // 選手名
                $rank = $element->filter('td')->eq(2)->text();                // 級別
                $raceCount = $element->filter('td')->eq(3)->text();           // 出走数
                $winRate = $element->filter('td')->eq(5)->text();             // 勝率
                $firstPlaceCount = $element->filter('td')->eq(4)->text();     // 1着数
                $firstPlacePercent = $element->filter('td')->eq(6)->text();   // 1着率 (%)
                $top2Percent = $element->filter('td')->eq(7)->text();         // 2連対率 (%)
                $top3Percent = $element->filter('td')->eq(8)->text();         // 3連対率 (%)
                $finalRoundCount = $element->filter('td')->eq(9)->text();     // 優出回数
                $championshipCount = $element->filter('td')->eq(10)->text();  // 優勝回数
                $averageStartTiming = $element->filter('td')->eq(11)->text(); // 平均スタートタイミング

                return [
                    'number' => Normalizer::normalize($number),
                    'name' => Normalizer::normalize($name),
                    'rank' => Normalizer::normalize($rank),
                    'race_count' => Normalizer::normalize($raceCount),
                    'win_rate' => Normalizer::normalize($winRate),
                    'first_place_count' => Normalizer::normalize($firstPlaceCount),
                    'first_place_percent' => Normalizer::normalize($firstPlacePercent),
                    'top_2_percent' => Normalizer::normalize($top2Percent),
                    'top_3_percent' => Normalizer::normalize($top3Percent),
                    'final_round_count' => Normalizer::normalize($finalRoundCount),
                    'championship_count' => Normalizer::normalize($championshipCount),
                    'average_start_timing' => Normalizer::normalize($averageStartTiming),
                ];
            });
    }
}
