<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabRequestTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_request_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_lab_id')->nullable();
            $table->char('request_type',1)->nullable();
            $table->unsignedBigInteger('certificate_id')->nullable();
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
        Schema::dropIfExists('lab_request_types');
    }
}
