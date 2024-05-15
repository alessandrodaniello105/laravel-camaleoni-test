@extends('layouts.app')

@section('content')

<div class="container">

    @if (session('success'))
        <div class="alert alert-success" role="alert">

            <p>{{session('success')}}</p>

            @if (Route::is('musicians.create'))
                <p>Iscritto: {{$newMusician->name}} {{$newMusician->surname}} - {{$newMusician->instrument->name}}</p>
            @else
                <p>Iscritto: {{$getMusician->name}} {{$getMusician->surname}} - {{$getMusician->instrument->name}}</p>
            @endif


            <p>Vuoi modificare qualcosa? <a href="{{route('musicians.edit', (Route::is('musicians.create')? $newMusician->id : $getMusician->id))}}" class="d-inline-block btn btn-warning ">Edit</a> </p>
        </div>

    @endif

    <h1 class="text-center my-3">Modulo iscrizione</h1>

    <form class="form-floating col" method="POST" action="{{route('musicians.store')}}">
        @csrf

        {{-- Name --}}
        <div class="row ">
            <div class="col-6 form-floating ">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Name"
                  id="name"
                  name="name"
                  min="3"
                  max="45"
                  required
                  oninput="checkInput('name')"
                >
                <label myref="form-label" for="name">Nome*</label>
            </div>

            {{-- Surname --}}
            <div class="col-6 form-floating">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Cognome"
                  id="surname"
                  name="surname"
                  min="3"
                  max="45"
                  required
                  oninput="checkInput('surname')"
                >

                <label myref="form-label" for="surname">Cognome*</label>
            </div>

            {{-- Instrument --}}
            <div class="col-12">

                <div class="text-center my-3 row ">
                    @foreach ($instruments as $instrument)
                        <div class="col-4 p-3 ">

                            <input
                            type="radio"
                            class="btn-check"
                            name="instrument_id"
                            id="`{{$instrument->name}}`-btn"
                            autocomplete="off"
                            value="{{$instrument->id}}"

                            >

                            <label
                            class="btn btn-secondary w-75 position-relative "
                            for="`{{$instrument->name}}`-btn">
                                <p>{{$instrument->name}}</p>
                                <img class="position-absolute" src="/assets/instruments-png/{{$instrument->icon}}" alt="">
                            </label>

                        </div>
                    @endforeach
                </div>

            </div>

            {{-- Email --}}
            <div class="col-6 form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Em@il">
                <label myref="form-label" for="email">Em@il</label>
            </div>

            {{-- Account IG --}}
            <div class="col-6 form-floating">
                <input type="text" class="form-control" name="ig_account" id="ig_account" placeholder="Account Instagram @alfonso">
                <label myref="form-label" for="ig_account">Account Instagram @alfonso...</label>
            </div>

            {{-- Send Form Button --}}
            <div class="col text-center ">
                <button type="submit" id="btn-form-send" class="btn btn-success disabled">Invia</button>
            </div>
        </div>




    </form>

</div>

{{-- <script src="../../js/select_instrument.js"></script> --}}

@endsection

{{-- Importing custom JS script --}}
@section('footer-scripts')
    @include('scripts.select-instrument')
@endsection
