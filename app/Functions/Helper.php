<?php

namespace App\Functions;

use App\Models\Instrument;
use App\Models\Musician;
use App\Models\Band;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\Builder;

use function Laravel\Prompts\alert;

class Helper {

    public static function randomizer($idBand) {

        // we select the band we want to fill with musicians
        $selectedBand = Band::where('id', $idBand)->with('musicians')->first();

        if (!$selectedBand->musicians->first()) {
            $drums = Instrument::where('name', 'Drums')->first();
            $musician = Helper::pickMusician($drums);
            $musician->is_picked  = 1;
            $musician->has_played = 1;
            $musician->update(['is_picked', 'has_played']);
            $selectedBand->musicians()->attach($musician);
        } else {
            // check and retrieve which instrument we need
            $randomInstrument = Helper::randomInstrument($selectedBand);

            // pick a musician for that/those instrument/instruments
            $musician = Helper::pickMusician($randomInstrument);
            $musician->is_picked  = 1;
            $musician->has_played = 1;
            $musician->update(['is_picked', 'has_played']);

            $selectedBand->musicians()->attach($musician);
        }

    }


    //TODO: implementare grandezza band /n. musicisti/ $howManyMusicians
    //TODO: implementare verifica almeno 1 musicista per strumento pescato
    public static function randomInstrument($selectedBand, $instrumentsInBand = []) {

        //  ------------ INITIALIZING MESSAGE/INSTRUMENTS & SELECTING BAND --------------//

        // $instrumentsInBand = [];
        $instrumentsInBand = Helper::checkInstruments($selectedBand, $instrumentsInBand);
        // Flash exception message if it was already been setted
        if (session()->exists('exceptionMessage')) {
            @dump('previous Message: exceptionMessage');
            session()->flash('exceptionMessage');
        }

        // Get the band
        // $selectedBand = Band::where('id', $idBand)->with('musicians')->first();

        //-----------------------------------------------------------------------------//


        // check if selected Band is already full
        // in positive case throw Exception and message
        if (count($selectedBand->musicians) >= 6) {

            throw new Exception('Non puoi aggiungere altri musicisti a questo gruppo');

        } else {

            // @dump(!$selectedBand->musicians->first());

            // @dump($selectedBand);

            // if 'selectedBand' has no musicians, return a drummer...

            $instrumentsInBand = Helper::checkInstruments($selectedBand, $instrumentsInBand);

            $randomInstrument = Instrument::all()->diff($instrumentsInBand)->random();

            $instrumentsInBand[] = $randomInstrument;
            return $randomInstrument;
        }




    }



    private static function checkInstruments($band, $instrumentArray) {
        foreach($band->musicians as $musician) {
            $instrumentArray[] = $musician->instrument;
        }
        return $instrumentArray;
    }
    private static function pickMusician($instrument) {

        $musician = Musician::with('instrument')
            ->inRandomOrder()
            ->whereRelation('instrument', 'name', $instrument->name)
            ->where('has_played', 0)
            ->first();

        if ($musician) return $musician;

        else throw new Exception('Non ci sono musicisti disponibili');
    }

    public static function resetHasPlayedState(): void {
        $musicians = Musician::where('has_played', 1)->get();
        // @dd(array($musicians));
        foreach($musicians as $musician) {
            // @dump($musician);
            $musician->has_played = false;
            $musician->is_picked  = false;
            $musician->save();
        }

    }

}







