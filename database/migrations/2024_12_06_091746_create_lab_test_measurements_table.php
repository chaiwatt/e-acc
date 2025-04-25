<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTestMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_test_measurements', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedBigInteger('lab_test_transaction_id')->nullable();
            $table->unsignedInteger('lab_test_transaction_id');
            $table->foreign('lab_test_transaction_id')->references('id')->on('lab_test_transactions')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('name_eng')->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->string('detail')->nullable();
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
        Schema::dropIfExists('lab_test_measurements');
    }
}
