<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;


class SendManualBandForm extends Component
{
    public $isDrumsSelected;
    public $isMinMusiciansSelected;
    public Bool $isDisabled;

    public function mount() {
        $this->updateProperties();

    }
    public function render()
    {
        if ($this->isDrumsSelected && $this->isMinMusiciansSelected) {
            $this->isDisabled = false;
        } else {
            $this->isDisabled = true;
        }
        $this->updateProperties();
        return view('livewire.send-manual-band-form');
    }

    // Requisites are:
    // minimum 2 musicians
    // drums always be present
    public function checkRequisites() {

        $pickedInstruments = Cache::get('picked_instruments', []);

        if (count($pickedInstruments) > 0 ) {
            $this->isDisabled = false;
        } else {
            $this->isDisabled = true;
        }


    }

    #[On('update-list')]
    public function updateProperties() {
        $pickedInstruments = Cache::get('picked_instruments', []);

        if (count($pickedInstruments) > 1) $this->isMinMusiciansSelected = true;
        else $this->isMinMusiciansSelected = false;

        if (in_array('Drums', $pickedInstruments)) $this->isDrumsSelected = true;
        else $this->isDrumsSelected = false;

        if (!$this->isDrumsSelected || !$this->isMinMusiciansSelected) $this->isDisabled = true;
        else $this->isDisabled = false;


        // @dump($pickedInstruments);
        // @dump($this->isMinMusiciansSelected);
        // @dump($this->isDrumsSelected);

    }

}
