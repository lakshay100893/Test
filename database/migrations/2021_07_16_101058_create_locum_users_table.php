<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocumUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locum_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->longText('home_address');
            $table->string('dob',100);
            $table->string('gmc_number')->nullable();
            $table->integer('specialty_id')->default(0);
            $table->integer('grade_id')->default(0);
            $table->string('profile_summary');
            $table->string('key_skills');
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
        Schema::dropIfExists('locum_users');
    }
}
