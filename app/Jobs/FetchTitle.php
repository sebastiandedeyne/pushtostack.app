<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Scraper\Scraper;
use App\Events\TitleFetched;

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
