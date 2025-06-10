<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingLabReportTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_lab_report_twos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tracking_assessment_id')->nullable();

            // Text fields
            $table->string('observation_count_text')->nullable();
            $table->string('lab_letter_received_date_text')->nullable();
            $table->string('email_sent_date_secondary_text')->nullable();
            $table->string('email_sent_date_tertiary_text')->nullable();

            // Checkbox fields (use char(10) to match 'yes'/'no' style)
            $table->char('checkbox_corrective_action_completed', 10)->nullable();
            $table->char('checkbox_corrective_action_incomplete', 10)->nullable();

            $table->string('remaining_nonconformities_count_text')->nullable();
            $table->text('remaining_nonconformities_list_text')->nullable();

            $table->char('checkbox_extend_certification', 10)->nullable();
            $table->char('checkbox_reject_extend_certification', 10)->nullable();
            $table->text('reason_for_extension_decision_text')->nullable();

            $table->char('checkbox_submit_remaining_evidence', 10)->nullable();
            $table->text('remaining_evidence_items_text')->nullable();
            $table->string('remaining_evidence_due_date_text')->nullable();
            $table->text('action_if_not_resolved_text')->nullable();

            $table->char('checkbox_unresolved_nonconformities', 10)->nullable();
            $table->text('subcommittee_consideration_action_text')->nullable();

            $table->char('checkbox_reduce_scope', 10)->nullable();
            $table->char('checkbox_suspend_certificate', 10)->nullable();

            // Attached files and persons
            $table->longText('attached_files')->nullable();
            $table->longText('persons')->nullable();

            // Status field
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
        Schema::dropIfExists('tracking_lab_report_twos');
    }
}
