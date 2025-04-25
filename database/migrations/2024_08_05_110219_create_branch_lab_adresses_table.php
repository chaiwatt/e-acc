<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchLabAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_lab_adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_lab_id')->nullable();
            $table->char('addr_no',10)->nullable()->comment('เลขที่');
            $table->char('addr_moo',20)->nullable()->comment('หมู่');
            $table->string('addr_soi',150)->nullable()->comment('ซอย');
            $table->string('addr_road',200)->nullable()->comment('ถนน');
            $table->string('addr_moo_en',20)->nullable();
            $table->string('addr_soi_en',150)->nullable();
            $table->string('addr_road_en',200)->nullable();
            $table->string('addr_province_id')->nullable();
            $table->string('addr_amphur_id')->nullable();
            $table->string('addr_tambol_id')->nullable();
            $table->char('postal',5)->nullable();
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
        Schema::dropIfExists('branch_lab_adresses');
    }
}
