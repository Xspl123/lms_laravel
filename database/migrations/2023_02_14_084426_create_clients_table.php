<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('clfull_name');
            $table->string('clphone');
            $table->string('clemail', 255);
            $table->text('clsection');
            $table->text('clbudget');
            $table->text('cllocation');
            $table->text('clzip');
            $table->text('clcity');
            $table->text('clcountry');
            $table->boolean('clis_active')->nullable()->default(1);
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('clients');
    }
}
