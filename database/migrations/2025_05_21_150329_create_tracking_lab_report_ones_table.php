<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingLabReportOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_lab_report_ones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tracking_assessment_id')->nullable();
            $table->string('book_no_text')->nullable();
            $table->text('audit_observation_text')->nullable();
            $table->char('chk_impartiality_yes', 10)->nullable();
            $table->char('chk_impartiality_no', 10)->nullable();
            $table->text('impartiality_text')->nullable();
            $table->char('chk_confidentiality_yes', 10)->nullable();
            $table->char('chk_confidentiality_no', 10)->nullable();
            $table->text('confidentiality_text')->nullable();
            $table->char('chk_structure_yes', 10)->nullable();
            $table->char('chk_structure_no', 10)->nullable();
            $table->text('structure_text')->nullable();
            $table->char('chk_res_general_yes', 10)->nullable();
            $table->char('chk_res_general_no', 10)->nullable();
            $table->text('res_general_text')->nullable();
            $table->char('chk_res_personnel_yes', 10)->nullable();
            $table->char('chk_res_personnel_no', 10)->nullable();
            $table->text('res_personnel_text')->nullable();
            $table->char('chk_res_facility_yes', 10)->nullable();
            $table->char('chk_res_facility_no', 10)->nullable();
            $table->text('res_facility_text')->nullable();
            $table->char('chk_res_equipment_yes', 10)->nullable();
            $table->char('chk_res_equipment_no', 10)->nullable();
            $table->text('res_equipment_text')->nullable();
            $table->char('chk_res_traceability_yes', 10)->nullable();
            $table->char('chk_res_traceability_no', 10)->nullable();
            $table->text('res_traceability_text')->nullable();
            $table->char('chk_res_external_yes', 10)->nullable();
            $table->char('chk_res_external_no', 10)->nullable();
            $table->text('res_external_text')->nullable();
            $table->char('chk_proc_review_yes', 10)->nullable();
            $table->char('chk_proc_review_no', 10)->nullable();
            $table->text('proc_review_text')->nullable();
            $table->char('chk_proc_method_yes', 10)->nullable();
            $table->char('chk_proc_method_no', 10)->nullable();
            $table->text('proc_method_text')->nullable();
            $table->char('chk_proc_sampling_yes', 10)->nullable();
            $table->char('chk_proc_sampling_no', 10)->nullable();
            $table->text('proc_sampling_text')->nullable();
            $table->char('chk_proc_sample_handling_yes', 10)->nullable();
            $table->char('chk_proc_sample_handling_no', 10)->nullable();
            $table->text('proc_sample_handling_text')->nullable();
            $table->char('chk_proc_tech_record_yes', 10)->nullable();
            $table->char('chk_proc_tech_record_no', 10)->nullable();
            $table->text('proc_tech_record_text')->nullable();
            $table->char('chk_proc_uncertainty_yes', 10)->nullable();
            $table->char('chk_proc_uncertainty_no', 10)->nullable();
            $table->text('proc_uncertainty_text')->nullable();
            $table->char('chk_proc_validity_yes', 10)->nullable();
            $table->char('chk_proc_validity_no', 10)->nullable();
            $table->text('proc_validity_text')->nullable();
            $table->char('chk_proc_reporting_yes', 10)->nullable();
            $table->char('chk_proc_reporting_no', 10)->nullable();
            $table->text('proc_reporting_text')->nullable();
            $table->char('chk_proc_complaint_yes', 10)->nullable();
            $table->char('chk_proc_complaint_no', 10)->nullable();
            $table->text('proc_complaint_text')->nullable();
            $table->char('chk_proc_nonconformity_yes', 10)->nullable();
            $table->char('chk_proc_nonconformity_no', 10)->nullable();
            $table->text('proc_nonconformity_text')->nullable();
            $table->char('chk_proc_data_control_yes', 10)->nullable();
            $table->char('chk_proc_data_control_no', 10)->nullable();
            $table->text('proc_data_control_text')->nullable();
            $table->char('chk_res_selection_yes', 10)->nullable();
            $table->char('chk_res_selection_no', 10)->nullable();
            $table->text('res_selection_text')->nullable();
            $table->char('chk_res_docsystem_yes', 10)->nullable();
            $table->char('chk_res_docsystem_no', 10)->nullable();
            $table->text('res_docsystem_text')->nullable();
            $table->char('chk_res_doccontrol_yes', 10)->nullable();
            $table->char('chk_res_doccontrol_no', 10)->nullable();
            $table->text('res_doccontrol_text')->nullable();
            $table->char('chk_res_recordcontrol_yes', 10)->nullable();
            $table->char('chk_res_recordcontrol_no', 10)->nullable();
            $table->text('res_recordcontrol_text')->nullable();
            $table->char('chk_res_riskopportunity_yes', 10)->nullable();
            $table->char('chk_res_riskopportunity_no', 10)->nullable();
            $table->text('res_riskopportunity_text')->nullable();
            $table->char('chk_res_improvement_yes', 10)->nullable();
            $table->char('chk_res_improvement_no', 10)->nullable();
            $table->text('res_improvement_text')->nullable();
            $table->char('chk_res_corrective_yes', 10)->nullable();
            $table->char('chk_res_corrective_no', 10)->nullable();
            $table->text('res_corrective_text')->nullable();
            $table->char('chk_res_audit_yes', 10)->nullable();
            $table->char('chk_res_audit_no', 10)->nullable();
            $table->text('res_audit_text')->nullable();
            $table->char('chk_res_review_yes', 10)->nullable();
            $table->char('chk_res_review_no', 10)->nullable();
            $table->text('res_review_text')->nullable();
            $table->char('report_display_certification_none', 10)->nullable();
            $table->char('report_display_certification_yes', 10)->nullable();
            $table->char('report_scope_certified_only', 10)->nullable();
            $table->char('report_scope_certified_all', 10)->nullable();
            $table->char('report_activities_not_certified_yes', 10)->nullable();
            $table->char('report_activities_not_certified_no', 10)->nullable();
            $table->char('report_accuracy_correct', 10)->nullable();
            $table->char('report_accuracy_incorrect', 10)->nullable();
            $table->text('report_accuracy_detail')->nullable();
            $table->char('multisite_display_certification_none', 10)->nullable();
            $table->char('multisite_display_certification_yes', 10)->nullable();
            $table->char('multisite_scope_certified_only', 10)->nullable();
            $table->char('multisite_scope_certified_all', 10)->nullable();
            $table->char('multisite_activities_not_certified_yes', 10)->nullable();
            $table->char('multisite_activities_not_certified_no', 10)->nullable();
            $table->char('multisite_accuracy_correct', 10)->nullable();
            $table->char('multisite_accuracy_incorrect', 10)->nullable();
            $table->text('multisite_accuracy_detail')->nullable();
            $table->char('certification_status_correct', 10)->nullable();
            $table->char('certification_status_incorrect', 10)->nullable();
            $table->text('certification_status_details')->nullable();
            $table->char('other_certification_status_correct', 10)->nullable();
            $table->char('other_certification_status_incorrect', 10)->nullable();
            $table->text('other_certification_status_details')->nullable();
            $table->char('lab_availability_yes', 10)->nullable();
            $table->char('lab_availability_no', 10)->nullable();
            $table->char('ilac_mra_display_no', 10)->nullable();
            $table->char('ilac_mra_display_yes', 10)->nullable();
            $table->char('ilac_mra_scope_no', 10)->nullable();
            $table->char('ilac_mra_scope_yes', 10)->nullable();
            $table->char('ilac_mra_disclosure_yes', 10)->nullable();
            $table->char('ilac_mra_disclosure_no', 10)->nullable();
            $table->char('ilac_mra_compliance_correct', 10)->nullable();
            $table->char('ilac_mra_compliance_incorrect', 10)->nullable();
            $table->text('ilac_mra_compliance_details')->nullable();
            $table->char('other_ilac_mra_compliance_no', 10)->nullable();
            $table->char('other_ilac_mra_compliance_yes', 10)->nullable();
            $table->text('other_ilac_mra_compliance_details')->nullable();
            $table->char('mra_compliance_correct', 10)->nullable();
            $table->char('mra_compliance_incorrect', 10)->nullable();
            $table->text('mra_compliance_details')->nullable();
            $table->text('evidence_mra_compliance_details_1')->nullable();
            $table->text('evidence_mra_compliance_details_2')->nullable();
            $table->text('evidence_mra_compliance_details_3')->nullable();
            $table->text('evidence_mra_compliance_details_4')->nullable();
            $table->char('offer_agreement_yes', 10)->nullable();
            $table->char('offer_agreement_no', 10)->nullable();
            $table->char('offer_ilac_agreement_yes', 10)->nullable();
            $table->char('offer_ilac_agreement_no', 10)->nullable();
            $table->longText('attached_files')->nullable();
            $table->longText('persons')->nullable();
            $table->char('status', 1)->nullable();
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
        Schema::dropIfExists('tracking_lab_report_ones');
    }
}
