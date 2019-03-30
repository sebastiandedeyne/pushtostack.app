@extends('layouts.app')

@push('head')
    <script src="{{ mix('js/app.js') }}" defer></script>
@endpush

@section('content')
    <div
        id="app"
        data-stacks="{{ json_encode($stacks) }}"
        data-user-uuid="{{ Auth::user()->uuid }}"
    ></div>
@endsection
