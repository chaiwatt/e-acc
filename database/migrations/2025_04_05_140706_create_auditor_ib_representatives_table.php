<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditorIbRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditor_ib_representatives', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assessment_id')->nullable();
            $table->foreign('assessment_id')->references('id')->on('app_certi_ib_assessment')->onDelete('cascade');
            $table->string('name',250)->default(0);
            $table->string('position',250)->default(0);
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
        Schema::dropIfExists('auditor_ib_representatives');
    }
}
