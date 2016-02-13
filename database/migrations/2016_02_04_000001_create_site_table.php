<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('sig_id');
            $table->string('sig_type');
            $table->string('sig_group');
            $table->string('sig_name');
            $table->integer('user_id')->length(10)->unsigned();
            $table->boolean('finished')->default(false);
            $table->boolean('active')->default(true);
        });

        Schema::table('site', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('site');
    }
}
