<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggest_people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile_no');
            $table->string('suggested_name');
            $table->string('suggested_mobile_no');
            $table->string('request_id');
            $table->string('suggested_by');
            $table->string('location');
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
        Schema::dropIfExists('suggest_people');
    }
}
