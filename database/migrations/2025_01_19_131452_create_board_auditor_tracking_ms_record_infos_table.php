<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardAuditorTrackingMsRecordInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_auditor_tracking_ms_record_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracking_auditor_id')->nullable();
            // $table->foreign('tracking_auditor_id')->references('id')->on('app_certi_tracking_auditors')->onDelete('cascade');
            $table->string('header_text1')->nullable();
            $table->string('header_text2')->nullable();
            $table->string('header_text3')->nullable();
            $table->string('header_text4')->nullable();
            $table->string('body_text1')->nullable();
            $table->string('body_text2')->nullable();
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
        Schema::dropIfExists('board_auditor_tracking_ms_record_infos');
    }
}
