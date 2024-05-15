<?php

namespace App\Console\Commands;

use App\Functions\Helper;
use App\Models\Band;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Event\Code\Throwable;

class TestRandomizer extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-randomizer
                            {idBand : The ID of the Band}
                            {numMusicians : How many musicians do you want to randomize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomize N musicians for random band';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $idBand = $this->argument('idBand');

        $selectedBandName = Band::where('id', $idBand)->get('name');



        $howManyMusicians = $this->argument('numMusicians');
        try {
            Helper::randomizer($idBand,$howManyMusicians);
            $this->info("You have successful randomized '{$howManyMusicians}' musicians to [{$idBand}] '{$selectedBandName}' Band ");
        } catch (Exception $e) {
            $this->info(report($e));
            $this->info('si ruppe');
            return false;
        }
    }


}
