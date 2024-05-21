<?php

namespace App\Livewire;

use App\Models\Instrument;
use App\Models\Musician;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;

class MusiciansList extends Component
{
    public Instrument $instrument;

    public $musicians;
    public $selectedMusicians;

    public $instruments;

    public $musiciansInList = [];
    public $isFull;

    public function mount() {
        $this->instruments = Instrument::with('musician')->get();

        session()->put('testBin', 'eccomi qui, sono testBin');

        $this->musicians = Musician::with('instrument')->where('instrument_id', $this->instrument->id)->get();

        $this->selectedMusicians = Cache::get('selected_musicians', []);

        $this->isFull = $this->checkIsFull();


    }
    public function render()
    {
        $this->instruments = Instrument::with('musician')->get();

        return view('livewire.musicians-list', [
            'instruments' => $this->instruments,
            'musicians'   => $this->musicians,
            // 'isFull'      => $this->isFull,
        ]);
    }


    #[On('update-list')]
    public function updateList() {
        $this->isFull = $this->checkIsFull();

        $this->instruments = Instrument::with('musician')->get();

    }


    //------------------------ TODO: DELETE THIS, KEEP THE ONE BELOW! ---------------------------

    //------------------------------------- THIS SHOULD WORK !-------------------------------------
    public function selectMusician($musicianId) {

        $this->dispatch('musician-added', $musicianId);
        $this->dispatch('update-list')->self();

    }

    // public function resetSelectedMusicians() {
    //     foreach($this->selectedMusicians as $musicianId) {
    //         $musician = Musician::find($musicianId)->first();
    //         $musician->is_picked = 0;
    //         $musician->save();
    //     }
    //     $this->selectedMusicians = Cache::flush();
    //     @dump('flushata correttamente la cache');
    // }

    public function checkIsFull() {
        $selectedMusicians = Cache::get('selected_musicians', []);
        if (count($selectedMusicians) == 6) {
            return true;
            // @dump('yes');
        } else {
            return false;
            // @dump('no');
        }
    }

}
