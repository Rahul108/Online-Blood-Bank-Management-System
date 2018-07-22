<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestBloodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_bloods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('for')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('area')->nullable();
            $table->string('urgency')->nullable();
            $table->string('within')->nullable();
            $table->string('contact')->nullable();
            $table->string('place_of_donation')->nullable();
            $table->integer('req_info')->nullable();
            $table->string('req_by')->nullable();
            $table->integer('status_info')->nullable();
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
        Schema::dropIfExists('request_bloods');
    }
}
