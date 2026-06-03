<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('id_wd');
            $table->string('manager');
            $table->string('name');
            $table->string('fonction');
            $table->string('projet_service');
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_activity')->nullable();
            $table->boolean('password_first_connection')->default(true);
            $table->integer('xp')->default(100);
            $table->integer('level')->default(2);
            $table->string('pseudo')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->integer('current_streak')->default(0);
            $table->integer('best_streak')->default(0);
            $table->integer('lose_streak')->default(0);
            $table->integer('best_lose_streak')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
