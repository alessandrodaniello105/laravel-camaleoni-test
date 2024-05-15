<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Musician;

// we use factory Faker to simulate musician's info
use Faker\Factory as Faker;

// to use inRandomOrder we should import DB façade
use Illuminate\Support\Facades\DB;


class MusiciansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create a new Faker instance
        $faker = Faker::create();

        for($i = 0; $i < 40; $i++) {

            $newMusician = new Musician;

            $newMusician->name = $faker->firstName();
            $newMusician->surname = $faker->lastName();

            $newMusician->instrument_id = Instrument::inRandomOrder()->first()->id;

            if ($i < 1) $newMusician->instrument_id = 1;

            $newMusician->save();
        }

    }
}
