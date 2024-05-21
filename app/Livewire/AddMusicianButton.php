<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class AddMusicianButton extends Component
{
    #[Reactive]
    public String $instrumentName;
    public $isPicked;


    public function mount() {
        $this->isPicked = $this->isInstrumentInList($this->instrumentName);

    }
    public function render()
    {

        $this->isPicked = $this->isInstrumentInList($this->instrumentName);

        return view('livewire.add-musician-button', [
            'isPicked' => 'gigi',
        ]);
    }


    #[On('reactivate-button')]
    public function reactivateButton($instrument) {
        if($this->instrumentName == $instrument) {
            $this->isPicked = true;
        } else {
            $this->isPicked = false;
        }
    }

    public function isInstrumentInList($instrumentName) {

        $pickedInstruments = Cache::get('picked_instruments', []);

        if ($pickedInstruments !== null) {
            if (!in_array($instrumentName, $pickedInstruments)) {
                return false;
            } else {
                return true;
            }
        }
    }
}
