<?php

namespace Tests\Fakes;

use App\Services\Scraper\Scraper;

class FakeScraper implements Scraper
{
    public function getTitle(string $url): string
    {
        return $url;
    }

    public function getFaviconUrl(string $url): string
    {
        return $url;
    }
}
