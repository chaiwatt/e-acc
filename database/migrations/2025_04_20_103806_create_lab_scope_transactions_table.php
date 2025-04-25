<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabScopeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_scope_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_lab_id');
            $table->foreign('app_certi_lab_id')->references('id')->on('app_certi_labs')->onDelete('cascade');
            $table->string('lab_type')->nullable();
            $table->char('request_type',10)->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('checkbox_main')->default(0);
            $table->string('address_number')->nullable();
            $table->string('village_no')->nullable();
            $table->string('address_soi')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_district')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_city_text')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('postcode')->nullable();
            $table->string('labress_no_eng')->nullable();
            $table->string('lab_moo_eng')->nullable();
            $table->string('lab_soi_eng')->nullable();
            $table->string('lab_street_eng')->nullable();
            $table->string('lab_district_eng')->nullable();
            $table->string('lab_amphur_eng')->nullable();
            $table->string('lab_province_eng')->nullable();
            $table->string('lab_province_text_eng')->nullable();
            $table->longText('lab_types')->nullable(); // เก็บ lab_types เป็น JSON
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
        Schema::dropIfExists('lab_scope_transactions');
    }
}
