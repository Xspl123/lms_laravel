<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('uphone');
            $table->string('urole');
            $table->string('domain_name')->unique();
            //$table->foreign('role_id')->references('id')->on('roles');
            $table->string('uexperience');
            // $table->string('ucname')->nullable();
            // $table->unsignedInteger('companies_id')->nullable();
            // $table->foreign('companies_id')->references('id')->on('companies');
            // $table->unsignedInteger('client_id')->nullable();
            // $table->foreign('client_id')->references('id')->on('clients');
            $table->boolean('uis_active')->nullable()->default(1);
            $table->string('utype')->default('Agent');
            $table->string('up_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        
    }
}
