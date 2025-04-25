<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignAssessmentReportTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_assessment_report_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('report_info_id')->nullable(); 
            $table->unsignedInteger('signer_id')->nullable(); 
            $table->char('app_id',20)->default(0);
            $table->char('certificate_type',10)->default(0)->comment('0=CB,1=IB,2=LAB');
            $table->string('signer_name',250)->default(0);
            $table->string('signer_position',250)->default(0);
            $table->string('signer_order',250)->default(0);
            $table->string('file_path',250)->nullable();
            $table->char('linesapce',2)->default(20);
            $table->char('report_type',1)->default(1);
            $table->string('view_url',200)->nullable();
            $table->char('approval',1)->default(0);
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
        Schema::dropIfExists('sign_assessment_report_transactions');
    }
}
