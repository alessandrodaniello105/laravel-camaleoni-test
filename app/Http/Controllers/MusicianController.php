<?php

namespace App\Http\Controllers;

use App\Models\Musician;
use Illuminate\Http\Request;
use App\Models\Instrument;
use Illuminate\Support\Facades\DB;
use App\Functions\Helper;

class MusicianController extends Controller
{

    /**
     * Access to name and surname and return a fullname string
     */
    public function getFullName(Musician $musician)
    {
        $selectedMusician = Musician::where('name', $musician->name)->first();
        $selectedMusicianName = $selectedMusician->name;
        $selectedMusicianSurname = $selectedMusician->surname;

        return "$selectedMusicianName $selectedMusicianSurname";

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $musicians = Musician::with('instrument')->orderBy('id','desc')->get();
        $instruments = Instrument::all();

        return view('musicians.index', compact('musicians', 'instruments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newMusicianId = Musician::max('id');
        $newMusician = Musician::where('id',$newMusicianId)->first();

        $instruments = Instrument::all();

        return view('musicians.create', compact('instruments', 'newMusician'));

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        session()->forget('success');
        $form_data_musician = $request->all();

        // if(!array_key_exists("services", $form_data_musician)){
        //     return redirect()->back()->with('createInstrumentError', 'Per favore seleziona almeno un servizio');
        // }

        $newMusician = new Musician;

        $newMusician->name = $form_data_musician["name"];
        $newMusician->surname = $form_data_musician["surname"];

        $form_instrument = $form_data_musician["instrument_id"];
        // $instrument = Instrument::where('name', '==', $form_instrument)->get()->id;

        $newMusician->instrument_id = $form_instrument;

        if(array_key_exists("email", $form_data_musician)) {
            $newMusician->email = $form_data_musician["email"];
        }

        if(array_key_exists("ig_account", $form_data_musician)) {
            $newMusician->ig_account = $form_data_musician["ig_account"];
        }

        // @dd(compact($newMusician));
        $newMusician->save();



        return redirect()->route('musicians.create')->with('success', 'Musicista iscritto con successo');

    }

    /**
     * Display the specified resource.
     */
    public function show(Musician $musician)
    {

        return redirect()->route('musicians.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($musician)
    {

        $instruments = Instrument::all();

        // @dd($musician->id);
        $getMusician = Musician::where('id', $musician)->first();

        @dump($getMusician);
        return view('musicians.edit', compact('getMusician', 'instruments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Musician $musician)
    {
        session()->forget('success');
        $editform_data_musician = $request->all();

        // @dd($editform_data_musician);
        $getMusician = Musician::where('id', $musician->id)->first();

        $getMusician->name = $editform_data_musician['name'];
        $getMusician->surname = $editform_data_musician['surname'];
        $getMusician->instrument_id = $editform_data_musician['instrument_id'];

        $getMusician->update($editform_data_musician);

        return redirect()->route('musicians.create', compact('getMusician'))->with('success', 'Musicista modificato con successo');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Musician $musician)
    {
        //
    }
}
