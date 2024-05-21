<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Cache;

class ManualBandForm extends Form
{
    public $bandName;


    public $musiciansIds;

    public $select;


    public function store() {
        @dump($this->all());
    }

}
