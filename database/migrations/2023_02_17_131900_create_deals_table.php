<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('dealOwner');
            $table->string('dealName');
            $table->string('accountName')->nullable();
            $table->string('type');
            $table->string('leadOwner');
            $table->unsignedInteger('lead_id')->nullable();
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->unsignedInteger('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->string('amount');
            $table->string('closingDate');
            $table->string('stage')->nullable();
            $table->string('probability')->nullable();
            $table->string('expectedRevenue')->nullable();
            $table->string('campaignSource')->nullable();
            $table->string('description');
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
        Schema::dropIfExists('deals');
    }
}
