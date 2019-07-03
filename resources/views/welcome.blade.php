@extends('layouts.app')

@section('content')
    <div class="container col-6 m-auto bg-dark">
        <form action="{{ route('entry.store') }}" method="post" id="newEntryForm">
            @include('entries.form')
        </form>
        @include('entries.results')
    </div>
@endsection