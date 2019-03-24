<?php

use App\Events\LinkAdded;
use App\Events\StackCreated;
use App\Events\UserRegistered;
use App\Stack;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
    ];

    public function run()
    {
        event(new UserRegistered([
            'uuid' => $userUuid = (string) Str::uuid(),
            'name' => 'Sebastian',
            'email' => 'sebastiandedeyne@gmail.com',
            'password' => bcrypt('secret'),
        ]));

        $user = User::findByUuid($userUuid);

        foreach ($this->links as [$url, $title, $stackName]) {
            if (!$stack = Stack::where('name', $stackName)->first()) {
                event(new StackCreated([
                    'uuid' => (string) Str::uuid(),
                    'user_uuid' => $user->uuid,
                    'name' => $stackName,
                    'order' => $user->stacks()->max('order') + 1,
                ]));

                $stack = Stack::where('name', $stackName)->firstOrFail();
            }

            event(new LinkAdded([
                'uuid' => (string) Str::uuid(),
                'user_uuid' => $user->uuid,
                'stack_uuid' => $stack->uuid,
                'url' => $url,
                'title' => $title,
                'added_at' => Carbon::now()->toDateTimeString(),
            ]));
        }
    }
}
