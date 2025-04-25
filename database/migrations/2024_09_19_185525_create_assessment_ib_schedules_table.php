<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentIbSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_ib_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_ib_id')->nullable();
            $table->date('assessment_date')->nullable();
            $table->char('assessment_time')->nullable();
            $table->longText('details')->nullable();
            $table->string('assessment_ids')->nullable();
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
        Schema::dropIfExists('assessment_ib_schedules');
    }
}
