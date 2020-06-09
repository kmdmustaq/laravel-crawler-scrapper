<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_infos_id');
            $table->foreign('company_infos_id')->references('id')->on('company_infos')->onDelete('cascade');
            $table->string('director_id')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('date_of_appointment')->nullable();
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
        Schema::dropIfExists('directors');
    }
}
