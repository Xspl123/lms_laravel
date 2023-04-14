<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->Integer('uuid')->unsigned();
            $table->Integer('p_id')->unsigned()->nullable();
            $table->Integer('owner_id')->unsigned()->nullable();
            $table->Integer('sender_id')->unsigned()->nullable();
            $table->Integer('template_id')->unsigned()->nullable();
            $table->string('to');
            $table->string('cc');
            $table->string('bcc');
            $table->string('body');
            $table->string('sender_name');
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
        Schema::dropIfExists('mails');
    }
}
