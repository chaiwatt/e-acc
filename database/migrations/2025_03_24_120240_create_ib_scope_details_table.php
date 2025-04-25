<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbScopeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_scope_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ib_scope_topic_id')->nullable(); 
            $table->foreign('ib_scope_topic_id')->references('id')->on('ib_scope_topics')->onDelete('cascade');
            $table->text('name')->nullable();
            $table->text('name_en')->nullable();
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
        Schema::dropIfExists('ib_scope_details');
    }
}
