{{--@auth only displays the code if user is logged in--}}
@auth
{{ csrf_field() }}
<div class="form-group">
    <label for="newEntryText">Leave an entry</label>
    <textarea class="form-control mb-2" name="content" id="newEntryText" required rows="3"></textarea>
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
@endauth
{{--Sperate section for the form javascript since it use the same section twise--}}
@section('formJs')
    @auth()
    <script>
        $(document).ready(function () {
            $('#submitNewEntry').prop('disabled', false);
        })
    </script>
    @endauth
@endsection