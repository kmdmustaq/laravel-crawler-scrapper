<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('company_infos_id');
            $table->foreign('company_infos_id')->references('id')->on('company_infos')->onDelete('cascade');
            
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            
            $table->string('email')->nullable();
            $table->string('reg_address')->nullable();
            // $table->string('state')->nullable();
            // $table->string('district')->nullable();
            // $table->string('city')->nullable();
            $table->integer('pin')->nullable();

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
        Schema::dropIfExists('contacts');
    }
}
