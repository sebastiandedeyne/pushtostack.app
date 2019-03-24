@extends('layouts.app')

@push('head')
    <script src="{{ mix('js/app.js') }}" defer></script>
@endpush

@section('content')
    <div
        id="app"
        data-base-path="{{ url('app') }}"
        data-initial-stacks="{{ json_encode($stacks) }}"
    ></div>
@endsection
