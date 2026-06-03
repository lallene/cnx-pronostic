<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('home_team');
            $table->string('away_team');
            $table->string('home_team_avatar')->nullable();
            $table->string('away_team_avatar')->nullable();
            $table->dateTime('match_date');
            $table->string('competition');
            $table->string('phase');
            $table->string('journee')->nullable();
            $table->string('groupe')->nullable();
            $table->integer('coefficient')->default(1);

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}


