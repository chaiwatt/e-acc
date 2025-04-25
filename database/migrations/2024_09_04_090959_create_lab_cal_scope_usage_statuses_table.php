<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCalScopeUsageStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_cal_scope_usage_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_lab_id')->nullable();
            $table->char('group',2)->nullable();
            $table->char('status',1)->default(2);
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
        Schema::dropIfExists('lab_cal_scope_usage_statuses');
    }
}
