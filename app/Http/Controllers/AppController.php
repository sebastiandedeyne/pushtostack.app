<?php

namespace App\Http\Controllers;

use App\Stack;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __invoke(Request $request)
    {
        $stacks = Stack::orderBy('order')->get();

        return view('app', compact('stacks'));
    }
}
