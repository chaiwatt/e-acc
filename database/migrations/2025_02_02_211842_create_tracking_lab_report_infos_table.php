<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingLabReportInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_lab_report_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tracking_assessment_id')->nullable();

            // 2.2
            $table->string('inp_2_2_assessment_on_site_chk')->nullable();
            $table->string('inp_2_2_assessment_at_tisi_chk')->nullable();
            $table->string('inp_2_2_remote_assessment_chk')->nullable();
            $table->string('inp_2_2_self_declaration_chk')->nullable();
            $table->string('inp_2_2_bug_fix_evidence_chk')->nullable();

            // 2.4
            $table->string('inp_2_4_defects_and_remarks_text')->nullable();
            $table->string('inp_2_4_doc_reference_date_text')->nullable();
            $table->string('inp_2_4_doc_sent_date1_text')->nullable();
            $table->string('inp_2_4_doc_sent_date2_text')->nullable();
            $table->string('inp_2_4_lab_bug_fix_completed_chk')->nullable();
            $table->string('inp_2_4_fix_approved_chk')->nullable();
            $table->string('inp_2_4_approved_text')->nullable();
            $table->string('inp_2_4_remain_text')->nullable();

            // 3.0
            $table->string('inp_3_lab_fix_all_issues_chk')->nullable();
            $table->string('inp_3_lab_fix_some_issues_chk')->nullable();
            $table->string('inp_3_approved_text')->nullable();
            $table->string('inp_3_remain_text')->nullable();
            $table->string('inp_3_lab_fix_failed_issues_chk')->nullable();
            $table->string('inp_3_lab_fix_failed_issues_yes_chk')->nullable();
            $table->string('inp_3_lab_fix_failed_issues_no_chk')->nullable();

            $table->string('file')->nullable();
            $table->string('file_client_name')->nullable();
            $table->string('persons')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('tracking_lab_report_infos');
    }
}
