@extends('layouts.app')

@section('content')
@php
    use App\Functions\Helper;
@endphp

{{-- @dump($results) --}}

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
        <h4>Nome Gruppo: {{$band->name}}</h4>
        <ul> Musicisti:
            @foreach ($band->musicians as $musician)
            <li>
                <span>
                    {{$musician->name}} {{$musician->surname}} - {{$musician->instrument->name}}
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
