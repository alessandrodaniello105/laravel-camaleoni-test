@extends('layouts.app')

@section('content')

<h1>Crea una band-session</h1>

{{-- MUSICIANS SELECTORS --}}
<div class="container-ctm musician-selectors">
    <div class="container-fluid">

        <form action="{{route('bands.store')}}" method="POST">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <livewire:manual-band-session-list />

                </div>
                <div class="row">

                    {{-- LEFT COLUMN --}}
                    <div class="col-10 d-flex flex-wrap justify-content-center">

                        @foreach ($instruments as $instrument)
                        {{-- INSTRUMENT CARD --}}
                        <div class="col-12 col-md-3 d-inline-block m-3 musicians-list-card">

                            <div class="card py-2">

                                <div class="row title-row text-center">
                                    {{-- INSTRUMENT CARD TITLE --}}
                                    <h4>{{$instrument->name}}</h4>

                                    {{-- INSTRUMENT ICON --}}
                                    <div class="offset-4 col-4">
                                        <div class="inst-icon mb-2">
                                            <img class="img-fluid img-thumbnail" src="/assets/instruments-png/{{$instrument->icon}}" alt="{{$instrument->icon}} - instrument image filename">
                                        </div>
                                    </div>
                                    {{-- //INSTRUMENT ICON --}}

                                    {{-- BUTTONS COL --}}
                                    <div class="col-4 ">
                                        <p>
                                            actions:
                                        </p>
                                        <div class="buttons-container flex flex-wrap justify-content-start p-2">

                                            <div
                                            class="btn btn-warning deselect-btn"
                                            id="deselect-musician-{{$instrument->name}}">
                                            X
                                            </div>

                                        <button
                                            type="button"
                                            class="btn btn-light insert-btn"
                                            id="deselect-musician-{{$instrument->name}}">
                                            &rightarrow;
                                            </button>

                                            {{-- <div
                                            class="btn btn-warning deselect-btn"
                                            id="deselect-musician-{{$instrument->name}}">
                                                X
                                            </div> --}}

                                        </div>
                                    </div>
                                    {{-- //BUTTONS COL --}}
                                </div>

                                {{-- MUSICIANS SELECT --}}
                                <div class="col px-2">
                                    <select class="form-select" name="{{strtolower($instrument->name) . '-musician'}}" id="{{strtolower($instrument->name)}}-select" size="5">
                                        {{-- <option selected>Open this select menu</option> --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($instrument->musician as $musician)

                                                <option {{($musician->id === 18)? 'selected' : ''}} name="{{strtolower($instrument->name)}}" value="{{$musician->id}}">{{$musician->name . ' ' . $musician->surname}}</option>

                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>

                                    </select>
                                </div>
                                {{-- //MUSICIANS SELECT --}}

                            </div>

                        </div>
                        {{-- //INSTRUMENT CARD --}}

                        @endforeach
                    </div>
                    {{-- //LEFT COLUMN --}}

                    {{-- RIGHT COLUMN --}}
                    <div class="col-2 text-center">
                        {{-- <p>
                            seconda colonna a destra
                        </p> --}}

                        <div class="col-12 col-md-3 d-inline-block m-3 musicians-list-card">

                            <div class="card py-2">

                                <div class="row title-row text-center">
                                    {{-- INSTRUMENT CARD TITLE --}}
                                    <h4>Manual Band</h4>

                                    {{-- INSTRUMENT ICON --}}
                                    <div class="offset-4 col-4">
                                        <div class="inst-icon mb-2">
                                            <img
                                              class="img-fluid img-thumbnail"
                                              src="/assets/instruments-png/{{$instrument->icon}}"
                                              alt="{{$instrument->icon}} - instrument image filename"
                                            >
                                        </div>
                                    </div>
                                    {{-- //INSTRUMENT ICON --}}

                                    {{-- BUTTONS COL --}}
                                    <div class="col-4 ">
                                        <p>
                                            actions:
                                        </p>
                                        <div class="buttons-container flex flex-wrap justify-content-start p-2">

                                            <div
                                            class="btn btn-warning deselect-btn"
                                            id="deselect-musician-{{$instrument->name}}">
                                            X
                                            </div>

                                            <button
                                                type="button"
                                                class="btn btn-light insert-btn"
                                                id="deselect-musician-{{$instrument->name}}">
                                                &rightarrow;
                                            </button>

                                        </div>
                                    </div>
                                    {{-- //BUTTONS COL --}}
                                </div>

                                {{-- MUSICIANS SELECT --}}
                                <div class="col px-2">
                                    <select class="form-select" name="{{strtolower($instrument->name) . '-musician'}}" id="{{strtolower($instrument->name)}}-select" size="5">
                                        {{-- <option selected>Open this select menu</option> --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($instrument->musician as $musician)

                                                <option {{($musician->id === 18)? 'selected' : ''}} name="{{strtolower($instrument->name)}}" value="{{$musician->id}}">{{$musician->name . ' ' . $musician->surname}}</option>

                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>

                                    </select>
                                </div>
                                {{-- //MUSICIANS SELECT --}}

                            </div>

                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark">SEND</button>
                        </div>
                    </div>
                    {{-- //RIGHT COLUMN --}}

                </div>
            </div>
        </form>


    </div>
</div>
{{-- //MUSICIANS SELECTORS --}}
@livewireScripts
@endsection

@section('footer-scripts')
    @include('scripts.custom-select')
@endsection
