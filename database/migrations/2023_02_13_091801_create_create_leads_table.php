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
            $table->string('uuid')->default(0);
            $table->string('lead_Name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('lead_Source')->nullable();
            $table->string('Owner');
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->string('fullName');;
            $table->string('last_Name');
            $table->string('titel')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone');
            $table->string('mobile');
            $table->string('website')->nullable();
            $table->string('lead_status');
            $table->string('industry')->nullable();
            $table->string('rating')->nullable();
            $table->string('noOfEmployees')->nullable();
            $table->string('annualRevenue')->nullable();
            $table->string('skypeID')->nullable();
            $table->string('secondaryEmail')->nullable();
            $table->string('twitter')->nullable();
            $table->string('street')->nullable();
            $table->string('pinCode')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('discription')->nullable();
            $table->unsignedBigInteger('companies_id');
            $table->foreign('companies_id')->references('id')->on('companies');
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
