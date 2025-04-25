<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardAuditoExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_audito_experts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('board_auditor_id');
            $table->foreign('board_auditor_id')->references('id')->on('board_auditors')->onDelete('cascade');
            $table->longText('expert')->nullable();
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
        Schema::dropIfExists('board_audito_experts');
    }
}
