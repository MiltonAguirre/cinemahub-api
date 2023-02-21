<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('duration');
            $table->unsignedBigInteger('director_id');
            $table->unsignedBigInteger('season_id');
            $table->timestamps();
        });
        Schema::table('episodes', function($table) {
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreign('director_id')->references('id')->on('directors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};
