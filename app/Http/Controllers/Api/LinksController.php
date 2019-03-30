<?php

namespace App\Http\Controllers\Api;

use App\Domain\Stack\LinkAdded;
use App\Domain\Stack\LinkDeleted;
use App\Domain\Stack\Models\Link;
use App\Domain\Stack\Models\Stack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;

class LinksController extends Controller
{
    public function index(Request $request)
    {
        return QueryBuilder::for(Link::class)
            ->where('user_uuid', $request->user()->uuid)
            ->allowedFilters('stack_uuid')
            ->latest('added_at')
            ->paginate();
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'url' => ['required', 'url'],
            'stack_uuid' => [
                'uuid',
                Rule::exists('stacks', 'uuid')->where(function ($query) use ($request) {
                    $query->where('user_uuid', $request->user()->uuid);
                }),
            ],
        ]);

        $linkUuid = uuid();

        $stackUuid = isset($attributes['stack_uuid'])
            ? $attributes['stack_uuid']
            : Stack::getInbox($request->user()->uuid)->uuid;

        event(new LinkAdded([
            'link_uuid' => $linkUuid,
            'stack_uuid' => $stackUuid,
            'url' => $attributes['url'],
            'title' => null,
            'added_at' => Carbon::now()->toDateTimeString(),
        ]));

        return Link::findByUuid($linkUuid);
    }

    public function destroy(Request $request, string $uuid)
    {
        if (! Link::findByUuid($uuid)->user_uuid === $request->user()->uuid) {
            abort(404);
        }

        event(new LinkDeleted([
            'link_uuid' => $uuid,
        ]));
    }
}
