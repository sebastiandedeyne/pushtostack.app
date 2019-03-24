<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\Stack;
use Illuminate\Http\Request;


class AppController extends Controller
{
    public function __invoke(Request $request)
    {
        $stacks = Stack::collection(
            $request->user()->stacks()->orderBy('order')->get()
        )->toArray($request);

        return view('app', compact('stacks'));
    }
}
