<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Link;
use Illuminate\Http\Request;
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
