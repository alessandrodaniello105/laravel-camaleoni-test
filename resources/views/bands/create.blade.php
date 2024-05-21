@extends('layouts.app')

@section('content')

{{-- MUSICIANS SELECTORS --}}
<div class="container-ctm musician-selectors">

    <h2>Crea una band-session</h2>

    @if (!empty($_SESSION['exceptionMessage']))

    <div class="alert alert-warning" role="alert">
        {{$_SESSION['exceptionMessage']}}
    </div>

    @endif

    {{-- TODO: LET THIS WORK! see BandController.store --}}
    @if (!empty($failure))
    <div class="alert alert-warning" role="alert">
        {{$failure}}
    </div>
    @endif

    <div class="container-fluid">
        {{-- <div class="row">
            <livewire:manual-band-session-list />

        </div> --}}
        <div class="row justify-content-center ">

            {{-- MANUAL BAND MODAL OPEN BUTTON --}}
            <div class="open-modal-button-container d-md-none ">
                <div class="open-modal" id="open-manual-band-modal" data-bs-toggle="modal" data-bs-target="#openManualBandModal"></div>
            </div>
            {{-- // MANUAL BAND MODAL OPEN BUTTON --}}

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button> --}}


            {{-- TODO: continue manual band into modal --}}
            <!-- MODAL -->
            <div class="modal fade" id="openManualBandModal" tabindex="-1" aria-labelledby="manualBandModalLabel" aria-hidden="true">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h1 class="modal-title fs-5" id="manualBandModalLabel">Modal title</h1>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>

                        <div class="modal-body">
                        ...
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="button" class="btn btn-primary">Save changes</button>

                        </div>

                    </div>

                </div>
            </div>
            <!-- //MODAL -->



            {{-- LEFT COLUMN --}}
            <div class="col .col-md-8 d-flex flex-wrap justify-content-center musicians-list-container">

                @foreach ($instruments as $instrument)

                <livewire:musicians-list live :key="$instrument->id" :instrument='$instrument' />
                @endforeach

            </div>
            {{-- //LEFT COLUMN --}}


            {{-- RIGHT COLUMN --}}

            {{-- //RIGHT COLUMN --}}
        </div>

    </div>


</div>
{{-- //MUSICIANS SELECTORS --}}



@livewireScripts
@endsection

@section('sidebar')



<aside class=".col-4  text-center align-self-center manual-band-list-container">
    {{-- <p>
        seconda colonna a destra
    </p> --}}
    <div class="mx-3">
        {{-- RANDOMIZER MODAL OPEN BUTTON --}}
        <button class="btn btn-outline-primary open-modal" id="randomizer-open-button" data-bs-toggle="modal" data-bs-target="#openRandomizerModal">
            OPEN RANDOMIZER
        </button>
        {{-- // RANDOMIZER MODAL OPEN BUTTON --}}

        {{-- TODO: continue randomizerr into modal --}}
        <!-- MODAL -->
        <div class="modal fade" id="openRandomizerModal" tabindex="-1" aria-labelledby="randomizerModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h1 class="modal-title fs-5" id="randomizerModalLabel">Randomizer</h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">
                        <form id="randomizer-form" action="{{route('bands.store')}}" method="POST">
                            @csrf

                            {{-- RANDOMIZER FORM FLAG --}}
                            <input type="checkbox" name="isRandomized" id="is-randomized" hidden checked>

                            {{-- NEW BAND NAME --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="band-name-label">What's the band name?</span>
                                <input type="text" class="form-control" name="bandName" id="band-name" placeholder="What's the band name?" aria-label="What's the band name?" aria-describedby="band-name-label">
                            </div>
                            {{-- //NEW BAND NAME --}}
                            <hr>
                            {{-- HOW MANY MUSICIANS IN NEW BAND --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="how-many-musicians-label">How Many Musicians?</span>
                                <input
                                  type="number"
                                  min="2"
                                  max="6"
                                  class="form-control"
                                  name="howManyMusicians"
                                  id="how-many-musicians"
                                  placeholder="How Many Musicians?"
                                  aria-label="How Many Musicians?"
                                  aria-describedby="how-many-musicians-label">
                            </div>
                            {{-- //HOW MANY MUSICIANS IN NEW BAND --}}



                            <livewire:send-manual-band-form formName="randomizer-form" wire:model="$isDisabled" live />

                        </form>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary">Save changes</button>

                    </div>

                </div>

            </div>
        </div>
        <!-- //MODAL -->

    </div>

    <div class="d-none d-md-inline-block">
        <form id="test-form" action="{{route('bands.store')}}" method="POST">
            @csrf
            <div class="col-12 col-md-3 d-inline-block m-3 musicians-list-card">

                <div class="card py-2">

                    {{-- MANUAL SELECT MUSICIANS (CREATE BAND) COMPONENT --}}
                    <livewire:manual-band-session-list live  :musicians="$allMusicians" />

                </div>

                @php
                    $counter = 6;
                    $counter = $counter - count($pickedInstruments);
                @endphp
            </div>
        </form>



        <livewire:send-manual-band-form formName="test-form" wire:model="$isDisabled" live />

    </div>

</aside>
@endsection


@section('footer-scripts')
    @include('scripts.custom-select')
@endsection
