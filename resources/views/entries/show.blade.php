@extends('layouts.app')
@section('content')
    <div class="container col-6 bg-dark">
            <div class="form-group">
                <div class="card bg-dark">
                    {{--Displays edit form if user is owner else just shows post--}}
                    @if($parent->user_id === \Illuminate\Support\Facades\Auth::id())
                        <form action="{{ route('entry.update', ['entry' => $parent->id]) }}" method="post" id="updateEntryForm">
                            <input type="hidden" name="_method" value="PATCH">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="editEntryText">Update your entry</label>
                                <textarea class="form-control mb-2" name="content" id="editEntryText" required rows="3">{{$parent->content}}</textarea>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <button type="submit" id="updateEntry" class="d-none">Submit</button>
                            </div>
                        </form>
                    @else
                        <div class="form-control pb-5 col-12" id="{{ $parent->id }}">{{ $parent->content }}</div>
                    @endif
                    <div class="form-text">
                        {{ $parent->user()->first()->username.' | ' .$parent->created_at .' | ' }}
                        {{-- Checks if entry has been updated --}}
                        @if((string)$parent->created_at !== (string)$parent->updated_at)
                            <span class="text-muted">(edited)</span> |
                        @endif
                        {{--Displays edit and delete links if user is owner--}}
                        @if($parent->user_id === \Illuminate\Support\Facades\Auth::id() || \Illuminate\Support\Facades\Auth::user()->isAdmin)
                            <div class="modal fade confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteEntry" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content text-danger">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteEntry">
                                                Are you sure you want to delete?
                                            </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger" id="sendDeleteEntry">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('entry.destroy', [ 'entry' => $parent->id ]) }}" class="d-none" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                {{ csrf_field() }}
                                <input type="submit" id="deleteEntry">
                            </form>
                             <a href="" id="delete" data-toggle="modal" data-target=".confirm-delete-modal">delete</a> |
                        @endif
                        @if($parent->user_id === \Illuminate\Support\Facades\Auth::id())
                            <a href="#" id="submitEditedEntry">update post</a> |
                        @endif
                    </div>
                </div>
            </div>
        {{--Only shows form if current entry doesn't have a parent--}}
        @if(!$parent->parent_id)
        <form action="{{ route('entry.store') }}" method="post" id="newEntryForm">
            <input type="hidden" name="parent_id" value="{{ $parent->id }}">
            @include('entries.form')
        </form>
        @endif
        @include('entries.results')
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#submitEditedEntry').on('click', function () {
                $('#updateEntry').click();
            });

            $('#sendDeleteEntry').on('click', function () {
                $('#deleteEntry').click();
            });
        })
    </script>
@endsection