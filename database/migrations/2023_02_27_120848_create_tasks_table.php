<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->Integer('p_id')->unsigned();
            $table->string('owner');
            $table->string('Subject');
            $table->string('DueDate');
            $table->string('Status');
            $table->string('Priority');
            $table->string('Reminder');
            $table->string('Repeat');
            $table->string('Description');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();            
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('tasks');
    }
}
