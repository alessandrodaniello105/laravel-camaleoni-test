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
        Schema::create('musicians', function (Blueprint $table) {
            $table->id();

            $table->string('name', 45);
            $table->string('surname', 45);
            $table->string('email', 100)->nullable();
            $table->string('ig_account', 30)->nullable();

            $table->bigInteger('instrument_id')->unsigned()->nullable();
            $table->foreign('instrument_id')->references('id')->on('instruments')->nullOnDelete()->after('id');

            $table->boolean('has_played')->default(false);

            $table->boolean('is_picked')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musicians');

        Schema::table('musicians', function (Blueprint $table) {
            $table->dropForeign(['instrument_id']);
            $table->dropColumn('instrument_id');
        });

    }
};
