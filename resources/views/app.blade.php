@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-Bx4pytHkyTDy3aJKjGkGoHPt3tvv6zlwwjc3iqN7ktaiEMLDPqLSZYts2OjKcBx1" crossorigin="anonymous">
    <script src="{{ mix('js/app.js') }}" defer></script>
@endpush

@section('content')
    <div
        id="app"
        data-stacks="{{ json_encode($stacks) }}"
        data-tags="{{ json_encode($tags) }}"
        data-user-uuid="{{ Auth::user()->uuid }}"
    ></div>
@endsection
