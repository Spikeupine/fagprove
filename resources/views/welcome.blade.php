@extends('layouts.app')

@section('content')
    @if(Auth::user())
    <div class="container col-6 m-auto bg-dark">
        <form action="{{ route('entry.store') }}" method="post" id="newEntryForm">
            {{ csrf_field() }}
            <div class="form-group">
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
                <div class="d-flex justify-content-end">
                    <button type="submit" id="submitNewEntry" class="btn btn-outline-primary" disabled>Submit</button>
                </div>
            </div>
        </form>
        @include('entries.results')
    </div>
    @endif
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#submitNewEntry').prop('disabled', false)
        })
    </script>
@endsection