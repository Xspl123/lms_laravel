<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->default(0);
            $table->string('cname')->unique();
            $table->string('cemail')->unique();
            $table->string('ctax_number')->nullable();
            $table->string('cphone');
            $table->string('ccity', 255);
            $table->string('cbilling_address', 255)->nullable();
            $table->string('ccountry', 255);
            $table->string('cpostal_code', 64)->nullable();
            $table->string('industry', 255)->nullable();
            $table->string('cemployees_size', 255)->nullable();
            $table->string('cfax')->nullable();;
            $table->string('cdescription', 255)->nullable();
            $table->string('domain_name')->unique()->nullable();
            $table->boolean('cis_active')->nullable()->default(0);
            //$table->unsignedInteger('client_id');
            //$table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('companies');
    }
}
