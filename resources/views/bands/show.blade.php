@extends('layouts.app')

@section('content')
<h2>Nome band: {{$selectedBand->name}}</h2>

<ul>
    @foreach ($selectedBand->musicians as $musician)
        <li>{{$musician->full_name}} - {{$musician->instrument->name}}</li>
    @endforeach
</ul>

<ul class="list-unstyled">

    <li class="m-2">
        <a class="btn btn-info" href="{{route('bands.create')}}">
            Torna alla creazione delle band
        </a>
    </li>

    <li class="m-2">
        <a class="btn btn-outline-primary" href="{{route('musicians.create')}}">
            Vai al modulo iscrizione musicisti
        </a>
    </li>
</ul>
@endsection
