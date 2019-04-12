<?php

namespace App\Http\Controllers;

use App\Domain\Stack\Models\Stack;
use App\Domain\Stack\Models\Tag;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __invoke(Request $request)
    {
        $stacks = Stack::orderBy('order')->get();
        $tags = Tag::orderBy('order')->get();

        return view('app', compact('stacks', 'tags'));
    }
}
