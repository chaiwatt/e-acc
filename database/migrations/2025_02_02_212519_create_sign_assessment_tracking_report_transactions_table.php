<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignAssessmentTrackingReportTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_assessment_tracking_report_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracking_report_info_id');
            $table->unsignedInteger('signer_id');
            $table->string('app_id')->nullable();
            $table->string('certificate_type')->nullable();
            $table->string('signer_name')->nullable();
            $table->string('signer_position')->nullable();
            $table->char('signer_order',1)->default(0);
            $table->string('file_path')->nullable();
            $table->char('linesapce', 5)->nullable();
            $table->string('view_url')->nullable();
            $table->char('approval',1)->nullable();
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
        Schema::dropIfExists('sign_assessment_tracking_report_transactions');
    }
}
