<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_scores', function (Blueprint $table) {
            $table->id();
            $table->string('service')->unique();

            $table->integer('nb_users')->default(0);
            $table->integer('participants')->default(0);
            $table->integer('nb_matches_joues')->default(0);
            $table->integer('total_pronostics')->default(0);
            $table->integer('correct_predictions')->default(0);
            $table->integer('points')->default(0);

            $table->decimal('participation_ratio', 5, 2)->default(0);
            $table->decimal('precision_ratio', 5, 2)->default(0);
            $table->decimal('global_score', 5, 2)->default(0);

            $table->integer('rank')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_scores');
    }
};
