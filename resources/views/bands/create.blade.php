@extends('layouts.app')

@section('content')

{{-- MUSICIANS SELECTORS --}}
<div class="container-ctm musician-selectors">

    <h2>Crea una band-session</h2>

    @include('errors.index')

    {{-- TODO: LET THIS WORK! see BandController.store --}}
    @if (!empty($_SESSION['failure']))
    <div class="alert alert-warning" role="alert">
        {{$failure}} {{$_SESSION['failure']}}
    </div>
    @endif

    <div class="container-fluid d-flex ">


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
            <!-- MANUAL BAND MODAL -->
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
            <!-- //MANUAL BAND MODAL -->



            {{-- LEFT COLUMN --}}
            <div class="col .col-md-8 d-flex flex-wrap justify-content-center musicians-list-container">

                @foreach ($instruments as $instrument)

                <livewire:musicians-list live :key="$instrument->id" :instrument='$instrument' />
                @endforeach

            </div>
            {{-- //LEFT COLUMN --}}



        </div>


    </div>

</div>
{{-- //MUSICIANS SELECTORS --}}




@livewireScripts
@endsection

@section('sidebar')
{{-- RIGHT COLUMN --}}

{{-- <p>
    seconda colonna a destra
</p> --}}
<div class="aside-container col col-3 align-self-center  .d-flex .flex-column">

    <div class="mx-3">

        {{-- RANDOMIZER MODAL OPEN BUTTON --}}
        <button class="btn btn-outline-primary open-modal" id="randomizer-open-button" data-bs-toggle="modal" data-bs-target="#openRandomizerModal">
            OPEN RANDOMIZER
        </button>
        {{-- // RANDOMIZER MODAL OPEN BUTTON --}}

        {{-- TODO: continue randomizerr into modal --}}
        <!-- RANDOMIZER MODAL -->
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

                            <span class="d-block mb-2">or</span>

                            {{-- HOW MANY RANDOMIZED BANDS --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="how-many-random-bands-label">How Many Randomized Bands?</span>
                                <input
                                    type="number"
                                    min="2"
                                    max="10"
                                    class="form-control"
                                    name="howManyRandomBands"
                                    id="how-many-random-bands"
                                    placeholder="How Many Randomized Bands?"
                                    aria-label="How Many Randomized Bands?"
                                    aria-describedby="how-many-random-bands-label"
                                    disabled>
                            </div>
                            {{-- //HOW MANY RANDOMIZED BANDS --}}

                            {{-- MULTIPLE RANDOMIZED BANDS FLAG --}}
                            <div class="form-check text-start ">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="isMultipleRandom"
                                    id="isMultipleRandom">

                                <label class="form-check-label" for="isMultipleRandom">
                                    Do you want to create multiple random bands?
                                </label>

                            </div>
                            {{-- //MULTIPLE RANDOMIZED BANDS FLAG --}}

                            <livewire:send-manual-band-form formName="randomizer-form" wire:model="$isDisabled" class="p-5" live />

                        </form>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary">Save changes</button>

                    </div>

                </div>

            </div>
        </div>
        <!-- //RANDOMIZER MODAL -->

    </div>

    <div class="d-none d-md-inline-block">

        <form id="test-form" action="{{route('bands.store')}}" method="POST">
            @csrf
            <div class="col-12 col-md-4 d-inline-block musicians-list-card">

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
</div>



{{-- //RIGHT COLUMN --}}
@endsection

@section('footer-scripts')
    @include('scripts.custom-select')
@endsection
