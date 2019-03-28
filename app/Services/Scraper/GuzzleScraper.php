<?php

namespace App\Services\Scraper;

use GuzzleHttp\Client;
use Spatie\Url\Url;
use Symfony\Component\DomCrawler\Crawler;

class GuzzleScraper implements Scraper
{
    /** @var \GuzzleHttp\Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getTitle(string $url): string
    {
        $titleNodes = $this->getCrawler($url)->filter('head > title');

        return $titleNodes->count()
            ? $titleNodes->first()->text()
            : '';
    }

    public function getFaviconUrl(string $url): string
    {
        $faviconNodes = $this->getCrawler($url)->filter(implode(', ', [
            'head > link[rel="shortcut icon"]',
            'head > link[rel="icon"]',
        ]));

        $faviconPath = $faviconNodes->count()
            ? $faviconNodes->first()->attr('href')
            : '';

        if (!$faviconPath) {
            return '';
        }

        $faviconUrl = Url::fromString($faviconPath);

        if (!$faviconUrl->getHost()) {
            $faviconUrl = Url::fromString($url)
                ->withPath($faviconUrl->getPath());
        }

        return (string) $faviconUrl;
    }

    private function getCrawler(string $url): Crawler
    {
        $html = (string) $this->client->get($url)->getBody();

        return new Crawler($html);
    }
}
