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
        $allBands = Band::with('musicians')->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])

                                ->orderByDesc('id')
                                ->get();

        $howManyMusicians = 3;


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

        @dd(Helper::availableInstruments());
        $drummers = Helper::isThereMinOneDrummer();

        $request->validate([
            'musiciansIds' => 'nullable|string',
            'bandName' => 'nullable|string',
            'howManyMusicians' => 'nullable|integer|min:2|max:6',
            'isMultipleRandom' => 'nullable|string',
        ]);

        if(!$drummers) {

            // @dump('flashed msg');
            return back()->with('failure', 'No drummers available');
        }
        // if request doesn't come from Randomizer form or doens't have musiciansIds
        // redirect back in creation band page
        else if (!isset($form_data_response['isRandomized']) && empty($form_data_response['musiciansIds'])) { // check 'empty' works
            // TODO: make 'failure' message visible in blade
            @dump('flashed failure state');
            return back()->with('failure', 'You had some problems with musicians or randomized form');
        }

        @dd('it continues here');
        $faker = Faker::create();

        $howManyBands = ($form_data_response['isMultipleRandom']) ?? 1;

        // @dd(Helper::checkInstrumentsVtwo());

        // TODO: manage multiple bands generation

            $newBand = Band::create();

            // if a name is received, newBand gets that name,
            // otherwise it gets "nome d'ufficio"
            $newBand->name = ($form_data_response['bandName']) ?? $faker->words(3, true);

            // if request comes from the manual method
            if (!isset($form_data_response['isRandomized'])) {


                // we retrieve musicians' ID from the form
                $musiciansIdsArray = explode(',', $form_data_response['musiciansIds']);

                foreach($musiciansIdsArray as $musicianId) {


                    $musician = Musician::where('id', $musicianId)->first();
                    // @dump($musician);

                    $musician->has_played = 1;
                    $musician->update(['has_played']);
                    $newBand->musicians()->attach($musician);

                }

                $newBand->save();
                // @dump($newBand->musicians());
                Cache::put('selected_musicians', []);
                Cache::put('picked_instruments', []);

                return redirect()->route('bands.show', $newBand);

            } else {

                // otherwise we use randomizer-form, we use randomizer() in Helper
                for ($numberBand = 0; $numberBand < $howManyBands; $numberBand++) {
                    $howManyMusicians = $form_data_response['howManyMusicians'] ?? rand(2, 6);

                    try {
                        for($i = 1; $i <= $howManyMusicians; $i++) {
                            Helper::randomizer($newBand->id);
                            $newBand->save();

                        }
                    } catch (Exception $e) {
                        $exceptionMessage = $e->getMessage();
                        $_SESSION['exceptionMessage'] = $exceptionMessage;
                        $newBand->delete();
                        return redirect()->route('bands.create');

                    }

                }
                return redirect()->route('bands.index');
            }



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
        $selectedBand = $band->with('musicians')->get(); // check if this is mandatory

        $musicians = $selectedBand->musicians;

        foreach($musicians as $musician) {
            $musician->is_picked  = 0;
            $musician->has_played = 0;
            $musician->update(['is_picked', 'has_played']);
        }

        $selectedBand->delete();

        return redirect()->route('bands.index');
    }
}
