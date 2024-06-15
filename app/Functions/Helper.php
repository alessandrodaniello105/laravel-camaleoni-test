<?php

namespace App\Functions;

use App\Models\Instrument;
use App\Models\Musician;
use App\Models\Band;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\Builder;

use Laravel\Prompts\alert;

class Helper {
    public static function isThereMinOneDrummer(): bool {
        $drummers = Musician::with('instrument')
                    ->where('instrument_id', 1)
                    ->whereBetween('created_at', [now()->subDay(), now()]) // now it clean bands at midnight
                    ->where('is_picked', 0)
                    ->get();

        // @dump($drummers->first());

        if ($drummers->first()) return true;
        else return false;

    }

    public static function isThereMinOneMusician() {

        $instruments     = Instrument::all();
        $instrumentsArray = strtolower($instruments->pluck('name'));
        //TODO: return instruments with no musician

        return $instrumentsArray;
    }
    public static function randomizer($idBand) {
        // Helper::checkInstrumentsVtwo();
        // we select the band we want to fill with musicians
        $selectedBand = Band::where('id', $idBand)->with('musicians')->first();

        $hasDrums = $selectedBand->musicians->filter(function($el) {
            return $el->instrument_id ?? 0;
        });

        if (!Helper::pickMusician(Instrument::where('name', 'Drums')->first())) {
            throw new Exception('No Drummers available');
        } else {
            if (!$selectedBand->musicians->first()) {
                $drums = Instrument::where('name', 'Drums')->first();
                $musician = Helper::pickMusician($drums);
                $musician->is_picked  = 1;
                $musician->has_played = 1; // change to 0

                $musician->update(['is_picked', 'has_played']);

                $selectedBand->musicians()->attach($musician);
            } else {
                // check and retrieve which instrument we need
                $randomInstrument = Helper::randomInstrument($selectedBand);

                // pick a musician for that/those instrument/instruments
                $musician = Helper::pickMusician($randomInstrument);
                $musician->is_picked  = 1;
                $musician->has_played = 1; // change to 0
                $musician->update(['is_picked', 'has_played']);

                $selectedBand->musicians()->attach($musician);
            }
            @dump($hasDrums);
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



    private static function checkInstruments($band, $instrumentArray): array {
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







