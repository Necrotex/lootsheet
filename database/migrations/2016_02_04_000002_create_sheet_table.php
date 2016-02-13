<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('site_id')->length(10)->unsigned();
            $table->double('modifier')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->float('points')->default(0);
            $table->double('total_isk')->default(0);
            $table->double('payout')->default(0);
            $table->double('corp_cut')->default(0);
        });

        Schema::table('sheet', function ($table) {
            $table->foreign('site_id')->references('id')->on('site')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sheet');
    }
}
