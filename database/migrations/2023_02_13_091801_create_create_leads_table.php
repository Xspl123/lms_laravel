<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_Name');
            $table->string('company');
            $table->string('email');
            $table->string('lead_Source');
            $table->string('lead_Owner');
            $table->string('first_Name');
            $table->string('last_Name');
            $table->string('titel');
            $table->string('fax');
            $table->string('mobile');
            $table->string('website');
            $table->string('lead_status');
            $table->string('industry');
            $table->string('tr');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('create_leads');
    }
}
