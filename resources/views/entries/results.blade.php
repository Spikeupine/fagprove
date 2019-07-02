@if($entries->count())
    <div class="form-group">
        @foreach ($entries as $entry)
            <div class="card my-1 bg-dark">
                <div class="form-control pb-5 col-12" id="{{ $entry->id }}">{{ $entry->content }}</div>
                <small class="form-text text-muted">
                    {{ $entry->user()->first()->username.' | ' .$entry->created_at }}
                    @if($entry->parent_id === null)
                        | <a href="{{ route('entry.show', ['entry' => $entry]) }}" class=" stretched-link">reply</a>
                    @endif
                </small>
            </div>
        @endforeach
        {{ $entries->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif