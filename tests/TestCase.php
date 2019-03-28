<?php

namespace Tests;

use App\Events\UserRegistered;
use App\Projections\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Services\Scraper\Scraper;
use Tests\Fakes\FakeScraper;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use InteractsWithContainer;

    /** @var \App\Projections\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $userUuid = uuid();

        event(new UserRegistered([
            'user_uuid' => $userUuid,
            'name' => 'Sebastian',
            'email' => 'sebastiandedeyne@gmail.com',
            'password' => bcrypt('secret'),
            'inbox_uuid' => uuid(),
        ]));

        $this->user = User::findByUuid($userUuid);

        $this->swap(Scraper::class, FakeScraper::class);
    }
}
