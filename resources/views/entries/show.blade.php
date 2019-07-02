@extends('layouts.app')
@section('content')
    <div class="container col-6 bg-dark">
            <div class="form-group">
                <div class="card bg-dark">
                    <div class="form-control pb-5 col-12" id="{{ $parent->id }}">{{ $parent->content }}</div>
                    <div class="form-text">
                        {{ $parent->user()->first()->username.' | ' .$parent->created_at }}
                    </div>
                </div>
            </div>
        <form action="{{ route('entry.store') }}" method="post" id="newEntryForm">
            <input type="hidden" name="parent_id" value="{{ $parent->id }}">
            @include('entries.form')
        </form>
        @include('entries.results')
    </div>
@endsection