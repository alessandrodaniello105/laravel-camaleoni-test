
@if ($message = Session::get('failure'))

<div class="alert alert-warning" role="alert">
    {{ $message }}
</div>

@endif
