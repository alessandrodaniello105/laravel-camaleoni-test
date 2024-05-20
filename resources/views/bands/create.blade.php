@extends('layouts.app')

@section('content')

<h1>Crea una band-session</h1>
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
{{-- MUSICIANS SELECTORS --}}
<div class="container-ctm musician-selectors">
    <div class="container-fluid">
        {{-- <div class="row">
            <livewire:manual-band-session-list />

        </div> --}}
        <div class="row">

            {{-- OPEN MANUAL BAND MODAL BUTTON --}}
            <div class="button-container d-md-none ">
                <div class="open-modal" id="open-manual-band-modal" data-bs-toggle="modal" data-bs-target="#exampleModal"></div>
            </div>
            {{-- // OPEN MANUAL BAND MODAL BUTTON --}}

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button> --}}
            {{-- TODO: continue manual band into modal --}}
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>

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





            {{-- LEFT COLUMN --}}
            <div class="col col-md-8 d-flex flex-wrap justify-content-center musicians-list-container">

                @foreach ($instruments as $instrument)

                <livewire:musicians-list live :key="$instrument->id" :instrument='$instrument' />
                @endforeach

            </div>
            {{-- //LEFT COLUMN --}}

            {{-- RIGHT COLUMN --}}
            <div class="d-none d-md-inline-block col-4 text-center">
                {{-- <p>
                    seconda colonna a destra
                </p> --}}

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
{{$counter}}
                    </div>
                </form>
                {{-- <button
                    type="submit"
                    form="test-form"
                    class="btn btn-dark {{ ($isConfirmedManualBand)? 'disabled' : '' }}">
                    SEND
                </button> --}}


                <livewire:send-manual-band-form />

            </div>
            {{-- //RIGHT COLUMN --}}

        </div>

    </div>

</div>
{{-- //MUSICIANS SELECTORS --}}
@livewireScripts
@endsection

@section('footer-scripts')
    @include('scripts.custom-select')
@endsection
