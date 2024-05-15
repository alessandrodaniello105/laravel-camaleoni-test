<?php

namespace App\Functions;

use App\Models\Instrument;
use App\Models\Musician;
use App\Models\Band;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Helper {

    //TODO: implementare grandezza band /n. musicisti/ $howManyMusicians
    //TODO: implementare verifica almeno 1 musicista per strumento pescato
    public static function randomizer($idBand, $howManyMusicians = 1) {

        //  ------------ INITIALIZING MESSAGE/INSTRUMENTS & SELECTING BAND --------------//

        $instrumentsInBand = [];

        // Flash exception message if it was already been setted
        if (session()->exists('exceptionMessage')) {
            @dump('flashato: exceptionMessage');
            session()->flash('exceptionMessage');
        }

        // Get the band
        $selectedBand = Band::where('id', $idBand)->with('musicians')->first();

        //-----------------------------------------------------------------------------//


        // check if selected Band is already full
        // in positive case throw Exception and message
        if (count($selectedBand->musicians) >= 6) {

            throw new Exception('Non puoi aggiungere altri musicisti a questo gruppo');

        } else {

            // if no musician was previously extracted/randomized,
            // extract a random drummer
            if (! $selectedBand->musicians->first()) {

                $drums = Instrument::where('name', 'Drums')->first();

                $drummer = Musician::with('instrument')
                ->whereBelongsTo($drums)
                ->inRandomOrder()
                ->first();

                $selectedBand->musicians()->attach($drummer);
                            // @dd($selectedBand);

                $howManyMusicians--;

                array_push($instrumentsInBand, $drummer);
            }
            // TODO: prova a passare oggetto musicista e non stringa nome strumento
            foreach($selectedBand->musicians as $musician) {
                if (! in_array($musician->instrument->name, $instrumentsInBand)) {
                    array_push($instrumentsInBand, $musician);
                }

            }

            // return $instrumentsInBand;
            @dump($instrumentsInBand);

            for($i = 1; $i <= $howManyMusicians; $i++) {
                // first, we want to know which instrument has to be extracted,
                //      checking which instruments have already been extracted

                // @dump( $instrumentsInBand);
                $instruments = Instrument::whereNot('name', join($instrumentsInBand))
                ->inRandomOrder()
                ->limit($howManyMusicians)
                ->get('name')
                ->toArray();

                //      we enlist N instruments to be extracted
                if (empty($instruments)) {

                    @dump('initializing $instruments');
                    // @dump('instrumentsArray: ' . count($instrumentsArray));

                }


                // @dump('instrumentsArray (after if statement): ' . count($instrumentsArray));


                // next, we go through the list, select first instrument and later extract
                //      a relative musician
                $instrument = Instrument::where('name', $instruments[0])->first();
                @dump('instrument: ' . $instrument);

                // @dd($instruments);

                // we assign the extracted musician to the band
                $selectedBand->musicians()->attach(Musician::with('instrument')
                                ->whereBelongsTo($instrument)
                                ->inRandomOrder()
                                ->first());

                // finally, we remove the instrument from extractable instruments list
                @dump(array_shift($instruments));
                array_shift($instruments);
                @dump($instruments);

                // $selectedBand->musicians()
            }
        }



    }



        // @dump($hasDrummer);
}

    // @dump(count($selectedBand->musicians));





