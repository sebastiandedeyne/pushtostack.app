<?php

namespace App\Domain\Stack\Jobs;

use App\Domain\Stack\TitleFetched;
use App\Services\Scraper\Scraper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class FetchTitle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /** @var string */
    public $url;

    /** @var string */
    public $linkUuid;

    public function __construct(string $url, string $linkUuid)
    {
        $this->url = $url;
        $this->linkUuid = $linkUuid;
    }

    public function handle(Scraper $scraper)
    {
        $title = $scraper->getTitle($this->url);

        if (!$title) {
            return;
        }

        event(new TitleFetched([
            'link_uuid' => $this->linkUuid,
            'title' => $title,
        ]));
    }
}
