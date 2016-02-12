<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePilotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilots', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('sheet_id')->length(10)->unsigned();
            $table->string('name');
            $table->string('corp')->nullable();
            $table->string('role');
            $table->string('ship');
            $table->double('cut')->nullable();
            $table->float('points');
            $table->boolean('paid')->default(false);

        });

        Schema::table('pilots', function ($table) {
            $table->foreign('sheet_id')->references('id')->on('sheet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pilots');
    }
}
