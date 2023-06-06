<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email__confirmations', function (Blueprint $table) {
            $table->id();
            $table->string('MAIL_DRIVER')->nullable();
            $table->string('MAIL_HOST')->nullable();
            $table->string('MAIL_PORT')->nullable();
            $table->string('MAIL_USERNAME')->nullable();
            $table->string('MAIL_PASSWORD')->nullable();
            $table->string('MAIL_ENCRYPTION')->nullable();
            $table->string('MAIL_FROM_ADDRESS')->nullable();
            $table->string('MAIL_FROM_NAME')->nullable();
            //$table->string('MAIL_REPLY_TO');
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
        Schema::dropIfExists('email__confirmations');
    }
}
