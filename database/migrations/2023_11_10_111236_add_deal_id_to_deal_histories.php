<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDealIdToDealHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('deal_id')->after('id'); // Change the type if necessary
            // Add other columns as needed

            // Foreign key constraint (assuming deals.id is the primary key)
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deal_histories', function (Blueprint $table) {
            // Drop the foreign key constraint first if it exists
            $table->dropForeign(['deal_id']);

            // Then drop the column
            $table->dropColumn('deal_id');
            // Drop other columns if necessary
        });
    }
}
