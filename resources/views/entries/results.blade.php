@if($entries->count())
    <div class="form-group">
        @foreach ($entries as $entry)
            <div class="card bg-dark">
                <div class="form-control pb-5 col-12" id="{{ $entry->id }}">{{ $entry->content }}</div>
                <small class="form-text text-muted">
                    {{ $entry->user()->first()->username.' | ' .$entry->created_at }}
                 | <a href="{{ route('entry.show', ['entry' => $entry]) }}">reply</a>
                </small>
            </div>
        @endforeach
        {{ $entries->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif