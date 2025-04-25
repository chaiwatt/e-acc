<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_cal_transactions', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedBigInteger('lab_cal_request_id')->nullable();
            $table->unsignedInteger('lab_cal_request_id');
            $table->foreign('lab_cal_request_id')->references('id')->on('lab_cal_requests')->onDelete('cascade');
                // เพิ่มฟิลด์ที่เกี่ยวข้องกับที่อยู่
            $table->string('key')->nullable();
            $table->integer('index')->nullable();
            $table->string('category')->nullable();
            $table->string('category_th')->nullable();
            $table->string('instrument')->nullable();
            $table->string('instrument_text')->nullable();
            $table->string('instrument_two')->nullable();
            $table->string('instrument_two_text')->nullable();
            $table->text('description')->nullable();
            $table->string('standard')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('lab_cal_transactions');
    }
}
