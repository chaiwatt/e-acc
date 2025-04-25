<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalibrationBranchInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calibration_branch_instruments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('calibration_branch_instrument_group_id')->comment('เครื่องมือสอบเทียบ');
            $table->string('name')->nullable()->comment('เครื่องมือ2สอบเทียบ');
            $table->char('state',1)->default(1);
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
        Schema::dropIfExists('calibration_branch_instruments');
    }
}
