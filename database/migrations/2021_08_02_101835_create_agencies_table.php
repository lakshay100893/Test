<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phn_no');
            $table->text('description');
            $table->text('address');
            $table->integer('is_blocked')->default(0);
            $table->integer('is_active')->default(1);
            $table->unsignedBigInteger('subscription_id');
            $table->timestamps();
        });
        

        Schema::create('agencyFiles', function (Blueprint $table) {
            $table->unsignedBigInteger('agencie_id');
            $table->foreign('agencie_id')->references('id')->on('agencies');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
}
