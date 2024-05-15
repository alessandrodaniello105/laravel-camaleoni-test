<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ManualBandForm extends Form
{
    public $bandName = '';


    public $musiciansIds = '';

    public function store() {
        @dump($this->all());
    }

}
