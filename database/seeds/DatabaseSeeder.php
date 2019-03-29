<?php

use App\Domain\Stack\LinkAdded;
use App\Domain\Stack\Models\Stack;
use App\Domain\Stack\StackCreated;
use App\Domain\User\Models\User;
use App\Domain\User\UserRegistered;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    protected $links = [
        [
            'https://programmingisterrible.com/post/173883533613/code-to-debug',
            'Programming',
        ],
        [
            'http://robnapier.net/go-is-a-shop-built-jig',
            'Programming',
        ],
        [
            'https://natashaskitchen.com/persimmon-bread-recipe/',
            'Recipes',
        ],
        [
            'https://food52.com/blog/23220-fall-ginger-cake-with-apple-butter-frosting',
            'Recipes',
        ],
        [
            'https://medium.learningbyshipping.com/writing-is-thinking-an-annotated-twitter-thread-2a75fe07fade?gi=c661791361ab',
            'Writing',
        ],
        [
            'https://medium.com/thrive-global/ikigai-the-japanese-secret-to-a-long-and-happy-life-might-just-help-you-live-a-more-fulfilling-9871d01992b7',
            'Life',
        ],
        [
            'https://medium.com/@caseorganic/why-do-we-keep-building-cars-with-touchscreens-alt-the-hidden-lives-of-touchscreens-55faf92799bf',
            'Design',
        ],
        [
            'https://www.nytimes.com/2018/05/16/technology/moviepass-economy-startups.html',
            'Business',
        ],
        [
            'https://frankchimero.com/blog/2016/new-yorker/',
            'Design',
        ],
        [
            'https://www.remoteonly.org/',
            'Work',
        ],
        [
            'https://reactjs.org/blog/2018/06/07/you-probably-dont-need-derived-state.html',
            'Programming',
        ],
        [
            'https://simonkollross.de/posts/vuejs-using-v-model-with-objects-for-custom-components',
            'Programming',
        ],
        [
            'https://spacecraft.ssl.umd.edu/akins_laws.html',
            'Programming',
        ],
        [
            'https://icidasset.com/writings/building-blocks/',
            'Programming',
        ],
        [
            'https://medium.com/startupwatching/i-emptied-my-savings-to-buy-a-newsletter-35508bf1c810',
            'Programming',
        ],
        [
            'https://csswizardry.com/2017/10/airplanes-and-ashtrays/',
            'Programming',
        ],
    ];

    public function run()
    {
        event(new UserRegistered([
            'user_uuid' => $userUuid = uuid(),
            'name' => 'Sebastian',
            'email' => 'sebastiandedeyne@gmail.com',
            'password' => bcrypt('secret'),
            'inbox_uuid' => uuid(),
        ]));

        $user = User::findByUuid($userUuid);

        foreach ($this->links as [$url, $stackName]) {
            if (!$stack = Stack::where('name', $stackName)->first()) {
                event(new StackCreated([
                    'stack_uuid' => uuid(),
                    'user_uuid' => $user->uuid,
                    'name' => $stackName,
                    'order' => Stack::where('user_uuid', $user->uuid)->max('order') + 1,
                ]));

                $stack = Stack::where('name', $stackName)->firstOrFail();
            }

            event(new LinkAdded([
                'link_uuid' => uuid(),
                'stack_uuid' => $stack->uuid,
                'url' => $url,
                'title' => null,
                'added_at' => Carbon::now()->toDateTimeString(),
            ]));
        }
    }
}
