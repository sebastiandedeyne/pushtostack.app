<?php

namespace App\Http\Controllers\Api;

use App\Events\LinkAdded;
use App\Events\LinkDeleted;
use App\Http\Controllers\Controller;
use App\Projections\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;

class LinksController extends Controller
{
    public function index()
    {
        return QueryBuilder::for(Link::class)
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
                    $query->where('user_id', $request->user()->id);
                }),
            ],
        ]);

        $linkUuid = uuid();

        event(new LinkAdded([
            'link_uuid' => $linkUuid,
            'user_uuid' => $request->user()->uuid,
            'stack_uuid' => $attributes['stack_uuid'] ?? $request->user()->inbox->uuid,
            'url' => $attributes['url'],
            'title' => null,
            'added_at' => Carbon::now()->toDateTimeString(),
        ]));

        return Link::findByUuid($linkUuid);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(string $uuid)
    {
        $this->authorize('delete', Link::findByUuid($uuid));

        event(new LinkDeleted([
            'link_uuid' => $uuid,
        ]));
    }
}
