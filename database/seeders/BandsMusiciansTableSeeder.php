<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Musician;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BandsMusiciansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for($i = 0; $i < 2; $i++) {
        //     for($m = 0; $m <= 3; $m++) {
        //         DB::table('band_musician')->insert([
        //             "band_id" => $i,
        //             "musician_id" => Musician::inRandomOrder()->first()->id
        //         ]);
        //     }
        // }

        $musicians = Musician::all();

        Band::all()->each(function ($band) use ($musicians) {
            $band->musicians()->attach(
                $musicians->random(rand(1, Musician::max('id')))->pluck('id')->toArray()
            );
        });



    }
}
