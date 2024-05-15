<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Band;
use App\Models\Musician;
use Carbon\Carbon;
// use Faker\Generator as Faker;
use Faker\Factory as Faker;

class BandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++) {
            $newBand = new Band;
            $faker = Faker::create();

            $newBand->name = $faker->words(4, true);
            // $newBand->has_played = $i < 3;
            $newBand->played_at = ($i < 3)? Carbon::now('Europe/Rome')->subMinutes(120) : null;




            $newBand->save();

        }


    }
}
