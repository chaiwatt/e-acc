<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCalMeasurementRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_cal_measurement_ranges', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedBigInteger('lab_cal_measurement_id')->nullable();
            $table->unsignedInteger('lab_cal_measurement_id');
            $table->foreign('lab_cal_measurement_id')->references('id')->on('lab_cal_measurements')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('range')->nullable();
            $table->string('uncertainty')->nullable();
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
        Schema::dropIfExists('lab_cal_measurement_ranges');
    }
}
