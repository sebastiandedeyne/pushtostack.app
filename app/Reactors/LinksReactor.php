<?php

namespace App\Reactors;

use App\Events\FaviconFetched;
use App\Events\LinkAdded;
use App\Events\TitleFetched;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;
use Symfony\Component\DomCrawler\Crawler;

class LinksReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        LinkAdded::class,
    ];

    public function onLinkAdded(LinkAdded $event)
    {
        $html = file_get_contents($event->url);

        $crawler = new Crawler($html);

        $titleNodes = $crawler->filter('head > title');

        if (!$event->title && $titleNodes->count()) {
            event(new TitleFetched([
                'link_uuid' => $event->link_uuid,
                'title' => $titleNodes->first()->text(),
            ]));
        }

        $faviconNodes = $crawler->filter('head > link[rel="shortcut icon"], head > link[rel="icon"]');

        if ($faviconNodes->count()) {
            $faviconUrl = $faviconNodes->first()->attr('href');

            $faviconUrlParts = parse_url($faviconUrl);

            if (!isset($faviconUrlParts['host'])) {
                $urlParts = parse_url($event->url);

                $faviconUrl = ($urlParts['scheme'] ?? 'https') . '://' . $urlParts['host'] . $faviconUrl;
            }

            $favicon = @file_get_contents($faviconUrl);

            if ($favicon) {
                $type = pathinfo($faviconUrl, PATHINFO_EXTENSION);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($favicon);

                event(new FaviconFetched([
                    'link_uuid' => $event->link_uuid,
                    'url' => $base64,
                ]));
            }
        }
    }
}
