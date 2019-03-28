<?php

namespace Tests\Unit\Projectors;

use App\Events\FaviconFetched;
use App\Events\LinkAdded;
use App\Events\TitleFetched;
use App\Projectors\LinksProjector;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LinksProjectorTest extends TestCase
{
    public function test_it_projects_a_link_when_added()
    {
        $linkUuid = uuid();

        app(LinksProjector::class)->onLinkAdded(
            new LinkAdded([
                'link_uuid' => $linkUuid,
                'user_uuid' => $this->user->uuid,
                'stack_uuid' => $this->user->inbox->uuid,
                'url' => 'http://example.com/',
                'title' => 'Hello, world!',
                'added_at' => Carbon::parse('2019-02-01 16:00:00')->toDateTimeString(),
            ])
        );

        $this->assertDatabaseHas('links', [
            'uuid' => $linkUuid,
            'user_id' => $this->user->id,
            'stack_id' => $this->user->inbox->id,
            'stack_uuid' => $this->user->inbox->uuid,
            'url' => 'http://example.com/',
            'title' => 'Hello, world!',
            'added_at' => Carbon::parse('2019-02-01 16:00:00')->toDateTimeString(),
        ]);
    }

    public function test_it_adds_a_title_when_fetched()
    {
        $linkUuid = uuid();

        app(LinksProjector::class)->onLinkAdded(
            new LinkAdded([
                'link_uuid' => $linkUuid,
                'user_uuid' => $this->user->uuid,
                'stack_uuid' => $this->user->inbox->uuid,
                'url' => 'http://example.com/',
                'title' => null,
                'added_at' => Carbon::parse('2019-02-01 16:00:00')->toDateTimeString(),
            ])
        );

        app(LinksProjector::class)->onTitleFetched(
            new TitleFetched([
                'link_uuid' => $linkUuid,
                'title' => 'Fetched title',
            ])
        );

        $this->assertDatabaseHas('links', [
            'uuid' => $linkUuid,
            'user_id' => $this->user->id,
            'stack_id' => $this->user->inbox->id,
            'stack_uuid' => $this->user->inbox->uuid,
            'url' => 'http://example.com/',
            'title' => 'Fetched title',
            'added_at' => Carbon::parse('2019-02-01 16:00:00')->toDateTimeString(),
        ]);
    }

    public function test_it_adds_a_favicon_url_when_fetched()
    {
        $linkUuid = uuid();

        app(LinksProjector::class)->onLinkAdded(
            new LinkAdded([
                'link_uuid' => $linkUuid,
                'user_uuid' => $this->user->uuid,
                'stack_uuid' => $this->user->inbox->uuid,
                'url' => 'http://example.com/',
                'title' => null,
                'added_at' => Carbon::parse('2019-02-01 16:00:00')->toDateTimeString(),
            ])
        );

        app(LinksProjector::class)->onFaviconFetched(
            new FaviconFetched([
                'link_uuid' => $linkUuid,
                'favicon_url' => '/favicons/example-com.jpg',
            ])
        );

        $this->assertDatabaseHas('links', [
            'uuid' => $linkUuid,
            'user_id' => $this->user->id,
            'stack_id' => $this->user->inbox->id,
            'stack_uuid' => $this->user->inbox->uuid,
            'url' => 'http://example.com/',
            'title' => 'http://example.com/',
            'favicon_url' => '/favicons/example-com.jpg',
            'added_at' => Carbon::parse('2019-02-01 16:00:00')->toDateTimeString(),
        ]);
    }
}
