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
        Schema::create('band_musician', function (Blueprint $table) {

            // $table->foreignId('band_id')->references('id')->on('bands');
            $table->unsignedBigInteger('band_id')->nullable();
            $table->foreign('band_id')->references('id')->on('bands')->nullOnDelete();

            // $table->foreignId('musician_id')->references('id')->on('musicians');
            $table->unsignedBigInteger('musician_id')->nullable();
            $table->foreign('musician_id')->references('id')->on('musicians')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('band_musician');
        Schema::table('band_musician', function (Blueprint $table) {
            $table->dropForeign(['band_id', 'musician_id']);
        });
    }
};
