<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTestTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_test_transactions', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedBigInteger('lab_test_request_id')->nullable();
            $table->unsignedInteger('lab_test_request_id');
            $table->foreign('lab_test_request_id')->references('id')->on('lab_test_requests')->onDelete('cascade');
            // เพิ่มฟิลด์ที่เกี่ยวข้องกับที่อยู่
            $table->string('key')->nullable();
            $table->integer('index')->nullable();
            $table->string('category')->nullable();
            $table->string('category_th')->nullable();
            $table->string('description')->nullable();
            $table->string('code')->nullable();
            $table->string('standard')->nullable();
            $table->string('test_field')->nullable();
            $table->string('test_field_eng')->nullable();
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
        Schema::dropIfExists('lab_test_transactions');
    }
}
