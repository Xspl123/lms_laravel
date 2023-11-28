<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->string('allday')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable(); 
            $table->string('host')->nullable(); 
            $table->string('participants')->nullable();
            $table->string('related')->nullable();
            $table->string('contactName')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('repeat')->nullable();
            $table->string('participantsRemainder')->nullable();
            $table->string('description')->nullable();
            $table->string('reminder')->nullable();
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
        Schema::dropIfExists('meetings');
    }
}
