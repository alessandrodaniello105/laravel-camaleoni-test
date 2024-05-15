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

                    {{-- (OLD) ADD MUSICIAN TO MANUAL BAND BUTTON --}}
                    {{-- <button
                        type="button"
                        class="btn btn-light add-btn"
                        id="add-musician-{{$instrument->name}}">
                        &rightarrow;
                    </button> --}}

                    {{-- ADD MUSICIAN BUTTON LIVEWIRE COMPONENT --}}
                    <livewire:add-musician-button wire:click="$refresh"  :instrumentName="$instrument->name"  />
                    {{-- <x-add-musician-button id="test-add-{{$instrument->name}}"  /> --}}

                    {{-- <button
                        type="button"
                        class="btn btn-light reset-btn"
                        wire:click="resetSelectedMusicians"
                        id="reset-musician-{{$instrument->name}}">
                        xxxx
                    </button> --}}

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
            <select
              class="form-select"
              name="{{strtolower($instrument->name) . '-musician'}}"
              id="{{strtolower($instrument->name)}}-select"

              size="5">
                {{-- <option selected>Open this select menu</option> --}}

                    @foreach ($instrument->musician as $musician)

                        {{-- @php
                            $musician = $musicians::find($musician->id);
                        @endphp --}}

                        @if (!$musician->has_played && !$musician->is_picked && !in_array($musician->id, $selectedMusicians))
                            <option
                                wire:key="{{$musician->id}}"
                                {{($musician->id === 18)? 'selected' : ''}} {{-- debug(preselected musician) --}}

                                name="{{strtolower($instrument->name)}}"
                                value="{{$musician->id}}">
                                {{$musician->full_name}}
                            </option>
                        @endif

                    @endforeach
                </div>

            </select>
        </div>
        {{-- //MUSICIANS SELECT --}}

    </div>
{{($isFull)? 'isFull': 'isNotFull'}}
</div>

@script
<script>

    let musiciansList         = document.getElementById('{{strtolower($instrument->name)}}-select');

    // let musicianAddButton    = document.getElementById('add-musician-{{$instrument->name}}');

    let musicianDeletebutton = document.getElementById('manual-band-delete-button');

    let musicianAddButton = document.getElementById('new-add-{{$instrument->name}}');

    musicianAddButton.addEventListener('click', function() {
        console.log(musiciansList)
        if(musiciansList.selectedOptions.length > 0) {
            let musicianId = musiciansList.selectedOptions[0].value;

            $wire.dispatch('musician-added', [musicianId]);

            console.log(musicianId);

        } else {
            // TODO: add alert message if no musician is selected
            // const alertElement = document.getElementById('alert-{{$instrument->name}}');

        }

    })
</script>
@endscript

