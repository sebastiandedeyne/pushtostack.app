<?php

namespace App\Jobs;

use App\Events\FaviconFetched;
use App\Projections\Favicon;
use App\Services\Scraper\Scraper;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Exception\NotReadableException;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\Url\Url;

class FetchFavicon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /** @var string */
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function handle(Scraper $scraper)
    {
        $faviconUrl = $scraper->getFaviconUrl($this->url);

        if (!$faviconUrl) {
            return;
        }

        $host = Url::fromString($this->url)->getHost();

        $extension = pathinfo(Url::fromString($faviconUrl)->getPath(), PATHINFO_EXTENSION);
        $tempFilePath = storage_path("app/temp/favicon-{$host}.{$extension}");

        try {
            (new Client())->get($faviconUrl, [
                'save_to' => $tempFilePath,
            ]);
        } catch (ClientException $e) {
            @unlink($tempFilePath);

            return;
        }

        $filename = str_slug($host);

        try {
            $filenameWithExtension = "{$filename}.jpg";

            Image::load($tempFilePath)
                ->width(64)
                ->height(64)
                ->format(Manipulations::FORMAT_JPG)
                ->save(storage_path("app/public/favicons/{$filenameWithExtension}"));

            event(new FaviconFetched([
                'host' => $host,
                'filename' => $filenameWithExtension,
            ]));
        } catch (NotReadableException $e) {
            $filenameWithExtension = "{$filename}.{$extension}";

            copy($tempFilePath, storage_path("app/public/favicons/{$filenameWithExtension}"));

            event(new FaviconFetched([
                'host' => $host,
                'filename' => $filenameWithExtension,
            ]));
        } catch (Exception $e) {
        } finally {
            @unlink($tempFilePath);
        }
    }
}
