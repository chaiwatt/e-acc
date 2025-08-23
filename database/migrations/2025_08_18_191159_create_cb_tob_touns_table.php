<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbTobTounsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_tob_touns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_cb_id')->nullable();
            $table->longText('template')->nullable();
            $table->string('report_type')->nullable();
            $table->char('status',20)->default("draft");
            $table->longText('signers')->nullable();
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
        Schema::dropIfExists('cb_tob_touns');
    }
}
