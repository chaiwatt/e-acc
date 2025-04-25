<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTestRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_test_requests', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedBigInteger('app_certi_lab_id')->nullable();
            $table->unsignedInteger('app_certi_lab_id');
            $table->foreign('app_certi_lab_id')->references('id')->on('app_certi_labs')->onDelete('cascade');
            $table->char('type',1)->default(2);
            $table->string('no')->nullable();
            $table->string('moo')->nullable();
            $table->string('soi')->nullable();
            $table->string('street')->nullable();
            $table->string('province_id')->nullable();
            $table->string('province_name')->nullable();
            $table->string('amphur_id')->nullable();
            $table->string('amphur_name')->nullable();
            $table->string('tambol_id')->nullable();
            $table->string('tambol_name')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('no_eng')->nullable();
            $table->string('moo_eng')->nullable();
            $table->string('soi_eng')->nullable();
            $table->string('street_eng')->nullable();
            $table->string('tambol_name_eng')->nullable();
            $table->string('amphur_name_eng')->nullable();
            $table->string('province_name_eng')->nullable();
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
        Schema::dropIfExists('lab_test_requests');
    }
}
