<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bands', function (Blueprint $table) {
            $table->id();

            $table->string('name', 45)->nullable();
            // $table->boolean('has_played')->default(false);
            $table->dateTime('played_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bands');
        // Schema::table('bands', function(Blueprint $table) {
        //     $table->dropForeign(['musician_id']);
        // });
    }
};
