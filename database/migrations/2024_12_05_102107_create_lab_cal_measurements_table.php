<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCalMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_cal_measurements', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedBigInteger('lab_cal_transaction_id')->nullable();
            $table->unsignedInteger('lab_cal_transaction_id');
            $table->foreign('lab_cal_transaction_id')->references('id')->on('lab_cal_transactions')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('lab_cal_measurements');
    }
}
