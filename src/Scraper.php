<?php

declare(strict_types=1);

namespace BVP\Scraper\TeikokuDB;

use BVP\Scraper\TeikokuDB\Converters\Converter;
use BVP\Scraper\TeikokuDB\Scrapers\LadyRacerScraper;
use InvalidArgumentException;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
final class Scraper
{
    /**
     * @var float
     */
    private const float DEFAULT_MIN_CALL_INTERVAL_SECONDS = 3.0;

    /**
     * @var float
     */
    private static float $minCallIntervalSeconds = self::DEFAULT_MIN_CALL_INTERVAL_SECONDS;

    /**
     * @var ?float
     */
    private static ?float $lastThrottleAt = null;

    /**
     * @return float
     */
    public static function getMinCallIntervalSeconds(): float
    {
        return self::$minCallIntervalSeconds;
    }

    /**
     * @param float $seconds
     * @return void
     */
    public static function setMinCallIntervalSeconds(float $seconds): void
    {
        if ($seconds < 3.0) {
            throw new InvalidArgumentException('interval must be 3 or greater.');
        }

        self::$minCallIntervalSeconds = $seconds;
    }

    /**
     * @return void
     */
    public static function throttle(): void
    {
        if (self::$lastThrottleAt !== null) {
            $elapsedSeconds = microtime(true) - self::$lastThrottleAt;
            $remainingSeconds = self::$minCallIntervalSeconds - $elapsedSeconds;

            if ($remainingSeconds > 0) {
                $sleepMicroseconds = Converter::toIntStrict(
                    $remainingSeconds * 1_000_000.0
                );

                usleep($sleepMicroseconds);
            }
        }

        self::$lastThrottleAt = microtime(true);
    }

    /**
     * @param ?non-negative-int $term
     * @param ?\Symfony\Component\BrowserKit\HttpBrowser $httpBrowser
     * @return array<non-negative-int, array<non-empty-string, mixed>>
     */
    public static function scrapeLadyRacers(?int $term = null, ?HttpBrowser $httpBrowser = null): array
    {
        self::throttle();

        return LadyRacerScraper::scrape($term, $httpBrowser);
    }
}
