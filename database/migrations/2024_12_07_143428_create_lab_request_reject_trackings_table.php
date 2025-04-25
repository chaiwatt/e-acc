<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabRequestRejectTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_request_reject_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_lab_id');
            $table->foreign('app_certi_lab_id')->references('id')->on('app_certi_labs')->onDelete('cascade');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('lab_request_reject_trackings');
    }
}
