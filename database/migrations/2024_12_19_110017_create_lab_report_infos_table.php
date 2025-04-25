<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabReportInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_report_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_lab_notice_id')->nullable(); 
            $table->foreign('app_certi_lab_notice_id')->references('id')->on('app_certi_lab_notices')->onDelete('cascade');
            
            // 2.2
            $table->char('inp_2_2_assessment_on_site',5)->nullable();
            $table->char('inp_2_2_assessment_at_tisi',5)->nullable();
            $table->char('inp_2_2_remote_assessment',5)->nullable();
            $table->char('inp_2_2_self_declaration',5)->nullable();

            // 2.5.1
            $table->char('inp_2_5_1_structure_compliance',5)->nullable();
            $table->char('inp_2_5_1_central_management_yes',5)->nullable();
            $table->char('inp_2_5_1_central_management_no',5)->nullable();
            $table->char('inp_2_5_1_quality_policy_yes',5)->nullable();
            $table->char('inp_2_5_1_quality_policy_no',5)->nullable();
            $table->char('inp_2_5_1_risk_assessment_yes',5)->nullable();
            $table->char('inp_2_5_1_risk_assessment_no',5)->nullable();
            $table->char('inp_2_5_1_other',5)->nullable();
            $table->string('inp_2_5_1_text_other1')->nullable();
            $table->string('inp_2_5_1_text_other2')->nullable();
            $table->char('inp_2_5_1_issue_found',5)->nullable();
            $table->longText('inp_2_5_1_detail')->nullable();

            // 2.5.2
            $table->char('inp_2_5_2_structure_compliance',5)->nullable();
            $table->char('inp_2_5_2_lab_management',5)->nullable();
            $table->string('inp_2_5_2_lab_management_details')->nullable();
            $table->char('inp_2_5_2_staff_assignment_yes',5)->nullable();
            $table->char('inp_2_5_2_staff_assignment_no',5)->nullable();
            $table->char('inp_2_5_2_responsibility_yes',5)->nullable();
            $table->char('inp_2_5_2_responsibility_no',5)->nullable();
            $table->char('inp_2_5_2_other',5)->nullable();
            $table->string('inp_2_5_2_text_other1')->nullable();
            $table->string('inp_2_5_2_text_other2')->nullable();
            $table->char('inp_2_5_2_issue_found',5)->nullable();
            $table->longText('inp_2_5_2_detail')->nullable();

            // 2.5.3
            $table->char('inp_2_5_3_structure_compliance',5)->nullable();
            $table->char('inp_2_5_3_personnel_qualification_yes',5)->nullable();
            $table->char('inp_2_5_3_personnel_qualification_no',5)->nullable();
            $table->char('inp_2_5_3_assign_personnel_appropriately_yes',5)->nullable();
            $table->char('inp_2_5_3_assign_personnel_appropriately_no',5)->nullable();
            $table->char('inp_2_5_3_training_need_assessment_yes',5)->nullable();
            $table->char('inp_2_5_3_training_need_assessment_no',5)->nullable();
            $table->char('inp_2_5_3_facility_and_environment_control_yes',5)->nullable();
            $table->char('inp_2_5_3_facility_and_environment_control_no',5)->nullable();
            $table->char('inp_2_5_3_equipment_maintenance_calibration_yes',5)->nullable();
            $table->char('inp_2_5_3_equipment_maintenance_calibration_no',5)->nullable();
            $table->char('inp_2_5_3_metrology_traceability_yes',5)->nullable();
            $table->char('inp_2_5_3_metrology_traceability_no',5)->nullable();
            $table->char('inp_2_5_3_external_product_service_control_yes',5)->nullable();
            $table->char('inp_2_5_3_external_product_service_control_no',5)->nullable();
            $table->char('inp_2_5_3_other',5)->nullable();
            $table->string('inp_2_5_3_text_other1')->nullable();
            $table->string('inp_2_5_3_text_other2')->nullable();
            $table->char('inp_2_5_3_issue_found',5)->nullable();
            $table->longText('inp_2_5_3_detail')->nullable();

            // 2.5.4
            $table->char('inp_2_5_4_structure_compliance',5)->nullable();
            $table->char('inp_2_5_4_policy_compliance_yes',5)->nullable();
            $table->char('inp_2_5_4_policy_compliance_no',5)->nullable();
            $table->char('inp_2_5_4_metrology_sampling_activity_yes',5)->nullable();
            $table->char('inp_2_5_4_metrology_sampling_activity_no',5)->nullable();
            $table->char('inp_2_5_4_procedure_review_request_yes',5)->nullable();
            $table->char('inp_2_5_4_procedure_review_request_no',5)->nullable();
            $table->char('inp_2_5_4_decision_rule_yes',5)->nullable();
            $table->char('inp_2_5_4_decision_rule_no',5)->nullable();
            $table->char('inp_2_5_4_agreement_customer_yes',5)->nullable();
            $table->char('inp_2_5_4_agreement_customer_no',5)->nullable();
            $table->char('inp_2_5_4_method_verification_yes',5)->nullable();
            $table->char('inp_2_5_4_method_verification_no',5)->nullable();
            $table->char('inp_2_5_4_sample_management_yes',5)->nullable();
            $table->char('inp_2_5_4_sample_management_no',5)->nullable();
            $table->char('inp_2_5_4_record_management_yes',5)->nullable();
            $table->char('inp_2_5_4_record_management_no',5)->nullable();
            $table->char('inp_2_5_4_uncertainty_evaluation_yes',5)->nullable();
            $table->char('inp_2_5_4_uncertainty_evaluation_no',5)->nullable();
            $table->char('inp_2_5_4_result_surveillance_yes',5)->nullable();
            $table->char('inp_2_5_4_result_surveillance_no',5)->nullable();
            $table->char('inp_2_5_4_proficiency_testing_yes',5)->nullable();
            $table->char('inp_2_5_4_proficiency_testing_no',5)->nullable();
            $table->char('inp_2_5_4_test_participation',5)->nullable();
            $table->string('inp_2_5_4_test_participation_details1')->nullable();
            $table->string('inp_2_5_4_test_participation_details2')->nullable();
            $table->char('inp_2_5_4_test_calibration',5)->nullable();
            $table->string('inp_2_5_4_calibration_details')->nullable();
            $table->char('inp_2_5_4_acceptance_criteria_yes',5)->nullable();
            $table->char('inp_2_5_4_acceptance_criteria_no',5)->nullable();
            $table->string('inp_2_5_4_acceptance_criteria1')->nullable();
            $table->string('inp_2_5_4_acceptance_criteria2')->nullable();
            $table->char('inp_2_5_4_lab_comparison',5)->nullable();
            $table->string('inp_2_5_4_lab_comparison_details1')->nullable();
            $table->string('inp_2_5_4_lab_comparison_details2')->nullable();
            $table->char('inp_2_5_4_lab_comparison_test',5)->nullable();
            $table->string('inp_2_5_4_lab_comparison_test_details')->nullable();
            $table->char('inp_2_5_4_lab_comparison_test_is_accept_yes',5)->nullable();
            $table->char('inp_2_5_4_lab_comparison_test_is_accept_no',5)->nullable();
            $table->string('inp_2_5_4_lab_comparison_test_is_accept_details1')->nullable();
            $table->string('inp_2_5_4_lab_comparison_test_is_accept_details2')->nullable();
            $table->char('inp_2_5_4_test_participation2',5)->nullable();
            $table->char('inp_2_5_4_other_methods',5)->nullable();
            $table->string('inp_2_5_4_other_methods_details1')->nullable();
            $table->string('inp_2_5_4_other_methods_details2')->nullable();
            $table->char('inp_2_5_4_report_approval_review_yes',5)->nullable();
            $table->char('inp_2_5_4_report_approval_review_no',5)->nullable();
            $table->char('inp_2_5_4_decision_rule2_yes',5)->nullable();
            $table->char('inp_2_5_4_decision_rule2_no',5)->nullable();
            $table->char('inp_2_5_4_document_for_criteria_yes',5)->nullable();
            $table->char('inp_2_5_4_document_for_criteria_no',5)->nullable();
            $table->char('inp_2_5_4_complaint_process_yes',5)->nullable();
            $table->char('inp_2_5_4_complaint_process_no',5)->nullable();
            $table->string('inp_2_5_4_complaint_number')->nullable();
            $table->char('inp_2_5_4_non_conformance_process_yes',5)->nullable();
            $table->char('inp_2_5_4_non_conformance_process_no',5)->nullable();
            $table->string('inp_2_5_4_non_conformance_number')->nullable();
            $table->char('inp_2_5_4_data_control_yes',5)->nullable();
            $table->char('inp_2_5_4_data_control_no',5)->nullable();
            $table->char('inp_2_5_4_data_transfer_control_yes',5)->nullable();
            $table->char('inp_2_5_4_data_transfer_control_no',5)->nullable();
            $table->char('inp_2_5_4_other',5)->nullable();
            $table->string('inp_2_5_4_text_other1')->nullable();
            $table->string('inp_2_5_4_text_other2')->nullable();
            $table->char('inp_2_5_4_issue_found',5)->nullable();
            $table->longText('inp_2_5_4_detail')->nullable();

            // 2.5.5
            $table->char('inp_2_5_5_structure_compliance',5)->nullable();
            $table->char('inp_2_5_5_data_control_option_a',5)->nullable();
            $table->char('inp_2_5_5_data_control_option_b',5)->nullable();
            $table->char('inp_2_5_5_data_control_policy_yes',5)->nullable();
            $table->char('inp_2_5_5_data_control_policy_no',5)->nullable();
            $table->char('inp_2_5_5_document_control_yes',5)->nullable();
            $table->char('inp_2_5_5_document_control_no',5)->nullable();
            $table->char('inp_2_5_5_record_keeping_yes',5)->nullable();
            $table->char('inp_2_5_5_record_keeping_no',5)->nullable();
            $table->char('inp_2_5_5_risk_management_yes',5)->nullable();
            $table->char('inp_2_5_5_risk_management_no',5)->nullable();
            $table->char('inp_2_5_5_risk_opportunity_yes',5)->nullable();
            $table->char('inp_2_5_5_risk_opportunity_no',5)->nullable();
            $table->char('inp_2_5_5_improvement_opportunity_yes',5)->nullable();
            $table->char('inp_2_5_5_improvement_opportunity_no',5)->nullable();
            $table->char('inp_2_5_5_non_conformance_yes',5)->nullable();
            $table->char('inp_2_5_5_non_conformance_no',5)->nullable();
            $table->char('inp_2_5_5_internal_audit_yes',5)->nullable();
            $table->char('inp_2_5_5_internal_audit_no',5)->nullable();
            $table->string('inp_2_5_5_audit_frequency')->nullable();
            $table->string('inp_2_5_5_last_audit_date')->nullable();
            $table->string('inp_2_5_5_audit_issues')->nullable();
            $table->char('inp_2_5_5_management_review_yes',5)->nullable();
            $table->char('inp_2_5_5_management_review_no',5)->nullable();
            $table->string('inp_2_5_5_last_review_date')->nullable();
            $table->char('inp_2_5_5_other',5)->nullable();
            $table->string('inp_2_5_5_text_other1')->nullable();
            $table->string('inp_2_5_5_text_other2')->nullable();
            $table->char('inp_2_5_5_issue_found',5)->nullable();
            $table->longText('inp_2_5_5_detail')->nullable();

            // 2.5.6.1.1
            $table->char('inp_2_5_6_1_1_management_review_no',5)->nullable();
            $table->char('inp_2_5_6_1_1_management_review_yes',5)->nullable();
            $table->char('inp_2_5_6_1_1_scope_certified_no',5)->nullable();
            $table->char('inp_2_5_6_1_1_scope_certified_yes',5)->nullable();
            $table->char('inp_2_5_6_1_1_activities_not_certified_yes',5)->nullable();
            $table->char('inp_2_5_6_1_1_activities_not_certified_no',5)->nullable();
            $table->char('inp_2_5_6_1_1_accuracy_yes',5)->nullable();
            $table->char('inp_2_5_6_1_1_accuracy_no',5)->nullable();
            $table->string('inp_2_5_6_1_1_accuracy_detail')->nullable();

            // 2.5.6.1.2
            $table->char('inp_2_5_6_1_2_multi_site_display_no',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_display_yes',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_scope_no',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_scope_yes',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_activities_not_certified_yes',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_activities_not_certified_no',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_accuracy_yes',5)->nullable();
            $table->char('inp_2_5_6_1_2_multi_site_accuracy_no',5)->nullable();
            $table->string('inp_2_5_6_1_2_multi_site_accuracy_details')->nullable();

            // 2.5.6.1.3
            $table->char('inp_2_5_6_1_3_certification_status_yes',5)->nullable();
            $table->char('inp_2_5_6_1_3_certification_status_no',5)->nullable();
            $table->string('inp_2_5_6_1_3_certification_status_details')->nullable();

            // 2.5.6.1.4
            $table->char('inp_2_5_6_1_4_display_other_no',5)->nullable();
            $table->char('inp_2_5_6_1_4_display_other_yes',5)->nullable();
            $table->string('inp_2_5_6_1_4_display_other_details')->nullable();
            $table->char('inp_2_5_6_1_4_certification_status_yes',5)->nullable();
            $table->char('inp_2_5_6_1_4_certification_status_no',5)->nullable();
            $table->string('inp_2_5_6_1_4_certification_status_details')->nullable();

            // 6.2
            $table->char('inp_2_5_6_2_lab_availability_yes',5)->nullable();
            $table->char('inp_2_5_6_2_lab_availability_no',5)->nullable();

            // 6.2.1
            $table->char('inp_2_5_6_2_1_ilac_mra_display_no',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_display_yes',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_scope_no',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_scope_yes',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_disclosure_yes',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_disclosure_no',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_compliance_yes',5)->nullable();
            $table->char('inp_2_5_6_2_1_ilac_mra_compliance_no',5)->nullable();
            $table->string('inp_2_5_6_2_1_ilac_mra_compliance_details')->nullable();

            // 6.2.2
            $table->char('inp_2_5_6_2_2_ilac_mra_compliance_no',5)->nullable();
            $table->char('inp_2_5_6_2_2_ilac_mra_compliance_yes',5)->nullable();
            $table->string('inp_2_5_6_2_2_ilac_mra_compliance_details')->nullable();
            $table->char('inp_2_5_6_2_2_mra_compliance_yes',5)->nullable();
            $table->char('inp_2_5_6_2_2_mra_compliance_no',5)->nullable();
            $table->string('inp_2_5_6_2_2_mra_compliance_details')->nullable();

            // 3.0
            $table->char('inp_3_0_assessment_results',5)->nullable();
            $table->string('inp_3_0_issue_count')->nullable();
            $table->string('inp_3_0_remarks_count')->nullable();
            $table->string('inp_3_0_deficiencies_details')->nullable();
            $table->string('inp_3_0_deficiency_resolution_date')->nullable();
            $table->char('inp_3_0_offer_agreement',5)->nullable();

            $table->string('file')->nullable();
            $table->string('file_client_name')->nullable();
            $table->longText('persons')->nullable();
            $table->char('status',1)->default(1);
            $table->char('notified_signers',1)->default(1);

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
        Schema::dropIfExists('lab_report_infos');
    }
}
