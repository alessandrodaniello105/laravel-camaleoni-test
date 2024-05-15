<?php

namespace App\Livewire;

use App\Livewire\Forms\ManualBandForm;
use App\Models\Musician;
use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;

use function Laravel\Prompts\alert;
use function PHPUnit\Framework\throwException;

class ManualBandSessionList extends Component
{
    public $selectedMusicians;

    public $pickedInstruments;

    public $isFull;
    public $name;
    public $bandName;
    public ManualBandForm $form;

    public $musicians;

    public function mount() {
        $this->selectedMusicians = Cache::get('selected_musicians', []);
        $this->pickedInstruments = Cache::get('picked_instruments', []);
        $this->musicians = Musician::class;
    }




    public function save() {
        // $formData = $this->form->all();
        $this->form->store();
        // return $this->route('bands.store', compact($formData));
    }

    public function send() {
        // @dump('wire:click="send"');
    }

    #[On('musician-added')]
    public function selectMusicianManualBand($musicianId) {
        // We select musician
        $selectedMusician = Musician::where('id', $musicianId)->first();

        // finally we push the instrument in the array of picked instruments
        $selectedMusicianInstrument = $selectedMusician->instrument->name;
        if (!in_array($musicianId, $this->selectedMusicians)) {

            $this->selectedMusicians[]   = $musicianId;
            $selectedMusician->is_picked = 1;
            $selectedMusician->save();

            $this->pickedInstruments[]   = $selectedMusicianInstrument;

            // @dump($selectedMusician);

            Cache::put('selected_musicians', $this->selectedMusicians);
            Cache::put('picked_instruments', $this->pickedInstruments);
            $this->dispatch('update-list');

        } else {

            $this->selectedMusicians = array_diff($this->selectedMusicians, [$musicianId]);
            $selectedMusician->is_picked = 0;
            $selectedMusician->save();


            Cache::put('selected_musicians', $this->selectedMusicians);

        }
        // $this->selectedMusicians = Cache::get('selected_musicians');
    }


    #[On('musician-deleted')]
    public function deleteMusicianManualBand($musicianId) {

        // We select musician
        $selectedMusician = Musician::where('id', $musicianId)->first();

        $selectedMusicianInstrument = $selectedMusician->instrument->name;

        if (in_array($musicianId, $this->selectedMusicians)) {

            $this->selectedMusicians = array_diff($this->selectedMusicians, [$musicianId]);
            $this->pickedInstruments = array_diff($this->pickedInstruments, [$selectedMusicianInstrument]);

            $selectedMusician->is_picked = 0;
            $selectedMusician->save();

            Cache::put('selected_musicians', $this->selectedMusicians);
            Cache::put('picked_instruments', $this->pickedInstruments);
            $this->dispatch('update-list');
            $this->dispatch('reactivate-button', $selectedMusicianInstrument);

        } else {
            throw new \Exception("errore nell'eliminazione del musicista dalla lista");
        }
    }


    public function resetManualBandList() {
        foreach($this->selectedMusicians as $musicianId) {
            $musician = Musician::where('id', $musicianId)->first();
            $musician->is_picked = 0;
            $this->selectedMusicians = array_diff($this->selectedMusicians, [$musicianId]);
            $musician->save();
        }
        Cache::forget('selected_musicians');
        Cache::forget('picked_instruments');
        $this->dispatch('update-list');


    }

    protected $listeners = ['musicianPicked' => 'musician-added'];


}
