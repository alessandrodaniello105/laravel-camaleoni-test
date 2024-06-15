@extends('layouts.app')

@section('content')
@php
    use App\Functions\Helper;
@endphp

{{-- @dump($results) --}}
{{$errorMsg ?? ''}}

@if (!empty($_SESSION['exceptionMessage']))

<div class="alert alert-warning" role="alert">
    {{$_SESSION['exceptionMessage']}}
</div>

@endif
<form action="">

    {{-- <button onsubmit="{{Helper::resetHasPlayedState()}}">Reset state</button> --}}
</form>

<ul>
    @foreach ($allBands as $band)
    <li>
        <h4>
            Nome Gruppo: {{$band->name}} | <form
          id="delete-band-form"
          action="{{route('bands.destroy', $band)}}"
          method="POST">
          @csrf @method('DELETE')<button type="submit" class="btn btn-warning">DEL</button></form>
        </h4>

        <ul> Musicisti:
            @foreach ($band->musicians as $musician)
            <li>
                <span>
                    {{$musician->full_name}} - {{$musician->instrument->name}}
                </span>
            </li>
            @endforeach
        </ul>

    </li>
    {{-- <li>
        <h4></h4>
    </li> --}}

  {{-- @foreach ($band->musicians as $musician)
      <li>
        {{$musician->name}}
      </li>
  @endforeach --}}

  @endforeach
</ul>
@endsection
