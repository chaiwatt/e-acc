<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbReportTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_report_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ib_assessment_id')->nullable();
            $table->longText('template')->nullable();
            $table->string('report_type')->nullable();
            $table->char('status',20)->default("draft");
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
        Schema::dropIfExists('ib_report_templates');
    }
}
