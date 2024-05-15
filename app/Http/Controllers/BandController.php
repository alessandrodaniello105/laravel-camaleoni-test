<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker;

use Illuminate\Support\Facades\Cache;
use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Functions\Helper;
use App\Models\Instrument;
use App\Models\Musician;
use Exception;

class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allBands = Band::with('musicians')->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->get();
        $howManyMusicians = 3;

        // @dump(now()->endOfDay());
        // RANDOMIZE MUSICIANS IN EXISTING BAND
        // $bandId = 3;
        // try {
        //     for($i = 1; $i <= $howManyMusicians; $i++) {

        //         Helper::randomizer($bandId);
        //     }
        // } catch (Exception $e) {
        //     $exceptionMessage = $e->getMessage();
        //     $_SESSION['exceptionMessage'] = $exceptionMessage;
        // }

        // $results = Band::select('bands.name AS band_name', DB::raw('CONCAT(musicians.name, " ", musicians.surname) AS musician_name'), 'instruments.name AS instrument_name', 'band_musician.updated_at as band_date')
        // ->join('band_musician', 'band_musician.band_id', '=', 'bands.id')
        // ->join('musicians', 'band_musician.musician_id', '=', 'musicians.id')
        // ->join('instruments', 'musicians.instrument_id', '=', 'instruments.id')
        // ->groupBy('bands.name', 'musicians.id', 'band_musician.updated_at')
        // ->get();


        return view('bands.index', compact('allBands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allMusicians = Musician::with('instrument','bands')->get();
        $instruments  = Instrument::with('musician')->get();

        $blabla       = "blabla";
        $testVar      = session()->get('testBin');

        $pickedInstruments = Cache::get('picked_instruments', []);

        return view('bands.create', compact('allMusicians', 'instruments', $blabla, 'testVar', 'pickedInstruments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $form_data_response = $request->all();
        @dd($form_data_response);
        $faker = Faker::create();

        $newBand = Band::create();

        // if a name is received, newBand gets that name
        if (isset($form_data_response['bandName'])) $newBand->name = $form_data_response['bandName'];
        // otherwise it gets "nome d'ufficio"
        else $newBand->name = $faker->words(4, true);



        // we retrieve musicians' ID from the form
        foreach($form_data_response as $key => $value) {
            // we want to exclude the csrf token
            if($key != "_token" && $key != "bandName") {
                $musician = Musician::where('id', $value)->first();
                // @dump($musician);

                $musician->has_played = 1;
                $musician->update(['has_played']);
                $newBand->musicians()->attach($musician);
            }
        }

        $newBand->save();
        // @dump($newBand->musicians());
        Cache::put('selected_musicians', []);
        Cache::put('picked_instruments', []);
        return redirect()->route('bands.show', $newBand);
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        $selectedBand = $band;

        return view('bands.show', compact('selectedBand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Band $band)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Band $band)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        //
    }
}
