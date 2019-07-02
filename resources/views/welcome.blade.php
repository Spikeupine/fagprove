@extends('layouts.app')

@section('content')
    @if(Auth::user())
    <div class="container">
        <form action="{{ route('entry.store') }}" method="post" id="newEntryForm">
            {{ csrf_field() }}
            <div class="form-group col-6">
                <label for="newEntryText">Leave an entry</label>
                <textarea class="form-control mb-2" name="content" id="newEntryText" rows="3"></textarea>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="btn btn-outline-primary float-right">Submit</button>
            </div>
        </form>
    </div>
    @endif
@endsection