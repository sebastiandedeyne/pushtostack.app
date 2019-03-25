<?php

use App\Events\LinkAdded;
use App\Events\StackCreated;
use App\Events\UserRegistered;
use App\Stack;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    protected $links = [
        [
            'https://programmingisterrible.com/post/173883533613/code-to-debug',
            'Write code that’s easy to delete, and easy to debug too.',
            'Programming',
        ],
        [
            'http://robnapier.net/go-is-a-shop-built-jig',
            'Go Is a Shop-built Jig',
            'Programming',
        ],
        [
            'https://natashaskitchen.com/persimmon-bread-recipe/',
            'Persimmon Bread Recipe - NatashasKitchen.com',
            'Recipes',
        ],
        [
            'https://food52.com/blog/23220-fall-ginger-cake-with-apple-butter-frosting',
            'A Swoopy Ginger-Apple Cake Perfect for Bundled-Up Fall Days',
            'Recipes',
        ],
        [
            'https://medium.learningbyshipping.com/writing-is-thinking-an-annotated-twitter-thread-2a75fe07fade?gi=c661791361ab',
            'Writing is Thinking',
            'Writing',
        ],
        [
            'https://medium.com/thrive-global/ikigai-the-japanese-secret-to-a-long-and-happy-life-might-just-help-you-live-a-more-fulfilling-9871d01992b7',
            'Ikigai: The Japanese Secret to a Long and Happy Life Might Just Help You Live a More Fulfilling Life',
            'Life',
        ],
        [
            'https://medium.com/@caseorganic/why-do-we-keep-building-cars-with-touchscreens-alt-the-hidden-lives-of-touchscreens-55faf92799bf',
            'The Hidden Cost of Touchscreens',
            'Design',
        ],
        [
            'https://www.nytimes.com/2018/05/16/technology/moviepass-economy-startups.html',
            'The Entire Economy Is MoviePass Now. Enjoy It While You Can.',
            'Business',
        ],
        [
            'https://frankchimero.com/blog/2016/new-yorker/',
            'Hi, I’d Like to Add Myself to the New Yorker',
            'Design',
        ],
        [
            'https://www.remoteonly.org/',
            'Remote only',
            'Work',
        ],
        [
            'https://reactjs.org/blog/2018/06/07/you-probably-dont-need-derived-state.html',
            'You Probably Don\'t Need Derived State',
            'Programming',
        ],
        [
            'https://simonkollross.de/posts/vuejs-using-v-model-with-objects-for-custom-components',
            'VueJS: Using v-model with objects for custom components',
            'Programming',
        ],
        [
            'https://spacecraft.ssl.umd.edu/akins_laws.html',
            'Akin\'s Laws of Spacecraft Design',
            'Programming',
        ],
        [
            'https://icidasset.com/writings/building-blocks/',
            'Building Blocks — I.A.',
            'Programming',
        ],
        [
            'https://medium.com/startupwatching/i-emptied-my-savings-to-buy-a-newsletter-35508bf1c810',
            'I emptied my savings to buy a newsletter',
            'Programming',
        ],
        [
            'https://csswizardry.com/2017/10/airplanes-and-ashtrays/',
            'Airplanes and Ashtrays',
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

        foreach ($this->links as [$url, $title, $stackName]) {
            if (!$stack = Stack::where('name', $stackName)->first()) {
                event(new StackCreated([
                    'stack_uuid' => uuid(),
                    'user_uuid' => $user->uuid,
                    'name' => $stackName,
                    'order' => $user->stacks()->max('order') + 1,
                ]));

                $stack = Stack::where('name', $stackName)->firstOrFail();
            }

            event(new LinkAdded([
                'link_uuid' => uuid(),
                'user_uuid' => $user->uuid,
                'stack_uuid' => $stack->uuid,
                'url' => $url,
                'title' => $title,
                'added_at' => Carbon::now()->toDateTimeString(),
            ]));
        }
    }
}
