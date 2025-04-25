<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCalScopeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_cal_scope_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->char('branch_type')->default(1)->comment('1 สำนักงานใหญ่ 2 สาขา');
            $table->char('site_type',50)->nullable();
            $table->unsignedBigInteger('app_certi_lab_id')->nullable();
            $table->unsignedBigInteger('branch_lab_adress_id')->nullable();
            $table->unsignedBigInteger('bcertify_calibration_branche_id')->nullable();
            $table->unsignedBigInteger('calibration_branch_instrument_group_id')->nullable();
            $table->unsignedBigInteger('calibration_branch_instrument_id')->nullable();
            $table->unsignedBigInteger('calibration_branch_parameter_one_id')->nullable();
            $table->text('parameter_one_value')->nullable();
            $table->unsignedBigInteger('calibration_branch_parameter_two_id')->nullable();
            $table->text('parameter_two_value')->nullable();
            $table->longLext('cal_method')->nullable();
            $table->char('group',2)->nullable();
            $table->timestamps();
        });
    }
// branch_lab_adresses
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_cal_scope_transactions');
    }
}
