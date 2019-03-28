<?php

namespace App\Services\Scraper;

interface Scraper
{
    public function getTitle(string $url): string;

    public function getFaviconUrl(string $url): string;
}
