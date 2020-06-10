<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingAndComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_and_complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_infos_id');
            $table->foreign('company_infos_id')->references('id')->on('company_infos')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->string('date_of_last_agm')->nullable();
            $table->string('date_of_balance_sheet')->nullable();
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
        Schema::dropIfExists('listing_and_complains');
    }
}
