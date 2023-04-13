<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('AccountOwner')->nullable();
            $table->string('AccountName')->nullable();
            $table->string('AccountSite')->nullable();
            $table->string('ParentAccount')->nullable();
            $table->string('AccountNumber')->nullable(); 
            $table->string('AccountType')->nullable(); 
            $table->string('Industry')->nullable();
            $table->string('AnnualRevenue')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Fax')->nullable();
            $table->string('Website')->nullable();
            $table->string('TickerSymbol')->nullable();
            $table->string('Employees')->nullable();
            $table->string('SICCode')->nullable();
            $table->string('BillingStreet')->nullable();
            $table->string('BillingCity')->nullable();
            $table->string('BillingState')->nullable();
            $table->string('BillingCode')->nullable(); 
            $table->string('BillingCountry')->nullable(); 
            $table->string('ShippingStreet')->nullable();
            $table->string('ShippingState')->nullable();
            $table->string('ShippingCode')->nullable();
            $table->string('ShippingCountry')->nullable();
            $table->string('Description')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
