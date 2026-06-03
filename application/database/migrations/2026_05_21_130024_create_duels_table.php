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
        Schema::create('duels', function (Blueprint $table) {

            $table->id();
            $table->foreignId('challenger_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('opponent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();

            $table->integer('xp_bet')->default(10);

            $table->string('challenger_prediction')->nullable();
            $table->string('opponent_prediction')->nullable();

            $table->enum('status', [
                'pending',
                'accepted',
                'refused',
                'cancelled',
                'resolved'
            ])->default('pending');

            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duels');
    }
};
