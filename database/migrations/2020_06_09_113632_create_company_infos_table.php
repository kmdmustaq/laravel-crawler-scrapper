<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cin');
            $table->string('name');
            $table->string('status');
            $table->string('date_of_incorp');
            $table->string('reg_num');
            $table->string('cateogy');
            $table->string('sub_cat');
            $table->string('class');
            $table->string('roc_code');
            $table->string('num_of_mem')->default(0);
            $table->string('url');
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
        Schema::dropIfExists('company_infos');
    }
}
