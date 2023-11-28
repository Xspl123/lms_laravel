<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('Owner');
            $table->string('firstName');
            $table->string('accountName');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('otherPhone');
            $table->string('assistant');
            $table->string('lastName');
            $table->string('vendorName');
            $table->string('title');
            $table->string('department');
            $table->string('homePhone');
            $table->string('fax')->nullable();
            $table->date('dateofBirth')->nullable();
            $table->string('mailingStreet');
            $table->string('mailingCity');
            $table->string('mailingState');
            $table->string('mailingZip');
            $table->string('mailingCountry');
            $table->string('otherStreet');
            $table->string('otherCity');
            $table->string('otherState');
            $table->string('otherZip');
            $table->string('otherCountry');
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
        Schema::dropIfExists('contacts');
    }
}
