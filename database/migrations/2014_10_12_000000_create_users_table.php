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
            $table->string('title');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('avtar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('two_factor_auth')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->integer('is_blocked')->default(0);
            $table->integer('is_active')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });


        DB::table('users')->insert(
            array(
                'title' => 'Software Developer',
                'first_name' => 'lakshay',
                'last_name' => 'verma',
                'email' => 'lakshay@sourcesoftsolutions.com',
                'avtar' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$10$F34Y9YECcvNBPAw8Z1db6OmDbBFN7CVQzsiVLiKEguWjmYo9hEaG2',
                'two_factor_auth' => NULL,
                'gender' => 'male',
                'is_blocked' => '0',
                'is_active' => '1',
                'remember_token' => NULL,
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );
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
