<div>

    {{-- <h2>Lista Musicisti</h2>
    <ul>
        @foreach ($musicians as $musician)
            <li wire:click="selectMusician({{$musician->id}})">
                {{ $musician->name }}
                @if (in_array($musician->id, $selectedMusicians))
                    (selezionato)
                @endif
            </li>
        @endforeach
    </ul> --}}
    <div class="row title-row text-center">
        {{-- INSTRUMENT CARD TITLE --}}
        <h4>Manual Band</h4>

        @php
            $counter = 6;
        @endphp

        <p>Posti disponibili: {{$counter = $counter - count($selectedMusicians)}}</p>

        {{-- INSTRUMENT ICON --}}
        <div class="offset-4 col-4">
            <div class="inst-icon mb-2">
                {{-- <img
                  class="img-fluid img-thumbnail"
                  src="/assets/instruments-png/{{$instrument->icon}}"
                  alt="{{$instrument->icon}} - instrument image filename"
                > --}}
            </div>
        </div>
        {{-- //INSTRUMENT ICON --}}

        {{-- BUTTONS COL --}}
        <div class="col-4 ">
            <p>
                actions:
            </p>
            <div class="buttons-container flex flex-wrap justify-content-start p-2">

                {{-- DESELECT SELECTED MUSICIAN --}}
                <div
                class="btn btn-warning deselect-btn {{($counter == 6)? 'disabled' : ''}}"
                id="manual-band-deselect-musician">
                X
                </div>

                {{-- DELETE SELECTED MUSICIAN FROM MANUAL BAND LIST --}}
                <button
                    type="button"
                    wire:click="$dispatch('update-list')"
                    class="btn btn-light delete-btn {{($counter == 6)? 'disabled' : ''}}"
                    id="manual-band-delete-musician">
                    &leftarrow;
                </button>

                {{-- RESET MANUAL BAND LIST BUTTON --}}
                <button
                    type="button"
                    class="btn btn-light reset-btn {{($counter == 6)? 'disabled' : ''}}"
                    wire:click="resetManualBandList()"
                    id="manual-band-reset-musician">
                    &leftarrow;&leftarrow;
                </button>

            </div>
        </div>
        {{-- //BUTTONS COL --}}
    </div>
    <h2>Musicisti Selezionati</h2>


    <div class="col px-2">

        {{-- <form id="form-manual-band" wire:submit="save"  method="POST">
            @csrf --}}

            <select
            class="form-select"
            .name="manual_band_session[]"
            id="manual-band-select"
            multiple
            size="5">

                @if ($selectedMusicians)
                @foreach ($selectedMusicians as $musicianId)

                    @php
                    // Writing this is the same as...
                    $musician = App\Models\Musician::find($musicianId);

                    // ...writing this
                    // $musician = array_filter($musicians, $musicianId);
                    @endphp

                    <option
                        wire:key="{{ $musician->id }}"
                        value="{{ $musician->id }}"
                        {{($isConfirmed)? 'selected' : ''}}>

                        {{-- {{ $musician->name . ' ' . $musician->surname }} --}}

                        {{ $musician->full_name . ' - ' . substr($musician->instrument->name, 0, 1) }}

                    </option>

                @endforeach

                @endif

            </select>

            {{-- <div wire:click="switchState" class="confirm-box">
                <label  for="manual-band-confirm">sure?</label>
                <input  id="manual-band-confirm" type="checkbox">
            </div> --}}

            <label for="manual-band-name-input">name band</label>
            <x-input-text name="bandName" />
            {{-- <input
              type="text"
              wire:model.fill.live="form.musiciansIds[]"
              id="manual-band-name-input"
              placeholder="Cartonio's Quartet..."

              class=" form-control my-2 "> --}}

            <x-input-text hidden name="musiciansIds" value="{{join(',', $selectedMusicians)}}" />
            {{-- <button
                type="submit"
                for="test-form"
                class="btn btn-dark">
                SEND
            </button> --}}

        {{-- </form> --}}
    </div>




    {{-- <button type="button" wire:click="send()" class="btn btn-dark btn-send">SEND</button> --}}

    {{-- <ul>
        lista
        @if ($pickedInstruments != null)
            @foreach ($pickedInstruments as $instrument)
                <li>{{ $instrument }}</li>

            @endforeach
        @endif
    </ul> --}}
</div>
@script
<script>

    let isConfirmedJs = 'true';

    if ($wire.pickedInstrument.length > 0) {
        let pickedInstruments = $wire.pickedInstruments;
        console.log(pickedInstruments)
        for(instrument in pickedInstruments) {
            console.log(instrument);
        }

    }

    let manualMusicianDeleteButton = document.getElementById('manual-band-delete-musician');
    let selectedMusicianId;



    manualMusicianDeleteButton.addEventListener('click', function() {
        let manualBandList         = document.getElementById('manual-band-select');

        if (manualBandList.selectedOptions.length > 0) {
            selectedMusicianId     = manualBandList.selectedOptions[0].value;

            $wire.dispatch('musician-deleted', [selectedMusicianId]);
        }

    })

</script>
@endscript
