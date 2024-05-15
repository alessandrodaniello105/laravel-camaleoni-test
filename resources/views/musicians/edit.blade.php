@extends('layouts.app')

@section('content')

<div class="container">
    <form method="POST" action="{{route('musicians.update', $getMusician->id)}}">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="row ">
            <div class="col-3 my-5 form-floating ">
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
                  value="{{$getMusician->name}}"
                >
                <label myref="form-label" for="name">Nome</label>
            </div>

            {{-- Surname --}}
            <div class="col-3 my-5 form-floating">
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
                  value="{{$getMusician->surname}}"
                >

                <label myref="form-label" for="surname">Cognome</label>
            </div>

            {{-- Instrument --}}
            <div class="col-4">

                <div class="text-center my-3 row ">
                    @foreach ($instruments as $instrument)
                        <div class="col-4 p-3 ">

                            <input
                            type="radio"
                            class="btn-check"
                            name="instrument_id"
                            id="`{{$instrument->name}}`-badge"
                            autocomplete="off"
                            value="{{$instrument->id}}"
                            {{($getMusician->instrument_id !== $instrument->id)? '' : 'checked'}}
                            >

                            <label
                            class="btn btn-secondary w-75 position-relative "
                            for="`{{$instrument->name}}`-badge">
                                <p>{{$instrument->name}}</p>
                            </label>

                        </div>
                    @endforeach
                </div>

            </div>

            {{-- Email --}}
            <div class="col-3 form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Em@il">
                <label myref="form-label" for="email">Em@il</label>
            </div>

            {{-- Account IG --}}
            {{-- Escaped '@' symbol by using '\' --}}
            <div class="col-3 form-floating">
                <input type="text" class="form-control" name="ig_account" id="ig_account" placeholder="Account Instagram @\alfonso">
                <label myref="form-label" for="ig_account">Account Instagram @\alfonso...</label>
            </div>

            {{-- Send Form Button --}}
            <div class="col text-center ">
                <button type="submit" id="btn-form-send" class="btn btn-success disabled ">Invia</button>
            </div>
        </div>

</div>

@endsection
@section('footer-scripts')
    @include('scripts.select-instrument')
@endsection
