<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instruments = config('instruments');

        foreach($instruments as $instrument) {
            DB::table('instruments')->insert($instrument);
        }
    }
}
