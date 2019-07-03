@if($entries->count())
    <div class="form-group">
        @foreach ($entries as $entry)
            <div class="card my-1 bg-dark">
                <div class="form-control pb-5 col-12" id="{{ $entry->id }}">{{ $entry->content }}</div>
                <small class="form-text text-muted">
                    {{ $entry->user()->first()->username.' | ' .$entry->created_at }}
                    @if((string)$entry->created_at !== (string)$entry->updated_at)
                        (edited) |
                    @endif
                    @if($entry->parent_id === null || $entry->user_id === \Illuminate\Support\Facades\Auth::id())
                        | <a href="{{ route('entry.show', ['entry' => $entry]) }}" class=" stretched-link">view</a>
                    @endif
                </small>
            </div>
        @endforeach
        {{ $entries->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif