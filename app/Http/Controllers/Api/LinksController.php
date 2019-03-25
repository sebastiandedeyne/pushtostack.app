<?php

namespace App\Http\Controllers\Api;

use App\Events\LinkAdded;
use App\Http\Controllers\Controller;
use App\Link;
use App\Stack;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
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
            'url' => 'required|url',
        ]);

        $linkUuid = uuid();

        event(new LinkAdded([
            'link_uuid' => $linkUuid,
            'user_uuid' => $request->user()->uuid,
            'stack_uuid' => Stack::first()->uuid,
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

    public function destroy($id)
    {
        //
    }
}
