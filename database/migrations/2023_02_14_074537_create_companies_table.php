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
            $table->string('company')->unique();
            $table->string('role');
            $table->string('experience');
            $table->string('email');
            $table->string('ctax_number')->nullable();
            $table->string('location');
            $table->string('cphone');
            $table->string('industry', 255)->nullable();
            $table->string('cemployees_size', 255)->nullable();
            $table->string('cfax')->nullable();;
            $table->string('cdescription', 255)->nullable();
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
