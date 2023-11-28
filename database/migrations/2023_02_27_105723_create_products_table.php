<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->string('productName');
            $table->string('productCode');
            $table->string('vendorName');
            $table->string('productActive');
            $table->string('manufacturer');
            $table->string('productCategory');
            $table->string('salesStartDate');
            $table->string('salesEndDate');
            $table->string('supportStartDate');
            $table->string('unitPrice');
            $table->string('commissionRate');
            $table->string('usageUnit');
            $table->string('qtyOrdered');
            $table->string('quantityinStock');
            $table->string('reorderLevel');
            $table->string('handler');
            $table->string('quantityinDemand');
            $table->string('description');
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
        Schema::dropIfExists('products');
    }
}
