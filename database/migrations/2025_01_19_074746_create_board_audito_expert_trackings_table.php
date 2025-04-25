<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardAuditoExpertTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_audito_expert_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracking_auditor_id')->nullable();
            $table->foreign('tracking_auditor_id')->references('id')->on('app_certi_tracking_auditors')->onDelete('cascade');
            $table->string('expert',250)->nullable();
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
        Schema::dropIfExists('board_audito_expert_trackings');
    }
}
