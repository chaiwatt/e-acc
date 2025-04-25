<?php

namespace App\Models\Certify;

use App\Models\Certify\Applicant\Notice;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class LabReportInfo extends Model
{
    use Sortable;
    protected $table = 'lab_report_infos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_notice_id',
        

        // 2.2
        'inp_2_2_assessment_on_site',
        'inp_2_2_assessment_at_tisi',
        'inp_2_2_remote_assessment',
        'inp_2_2_self_declaration',

        // 2.5.1
        'inp_2_5_1_structure_compliance',
        'inp_2_5_1_central_management_yes',
        'inp_2_5_1_central_management_no',
        'inp_2_5_1_quality_policy_yes',
        'inp_2_5_1_quality_policy_no',
        'inp_2_5_1_risk_assessment_yes',
        'inp_2_5_1_risk_assessment_no',
        'inp_2_5_1_other',
        'inp_2_5_1_text_other1',
        'inp_2_5_1_text_other2',
        'inp_2_5_1_issue_found',
        'inp_2_5_1_detail',

        // 2.5.2
        'inp_2_5_2_structure_compliance',
        'inp_2_5_2_lab_management',
        'inp_2_5_2_lab_management_details',
        'inp_2_5_2_staff_assignment_yes',
        'inp_2_5_2_staff_assignment_no',
        'inp_2_5_2_responsibility_yes',
        'inp_2_5_2_responsibility_no',
        'inp_2_5_2_other',
        'inp_2_5_2_text_other1',
        'inp_2_5_2_text_other2',
        'inp_2_5_2_issue_found',
        'inp_2_5_2_detail',

        // 2.5.3
        'inp_2_5_3_structure_compliance',
        'inp_2_5_3_personnel_qualification_yes',
        'inp_2_5_3_personnel_qualification_no',
        'inp_2_5_3_assign_personnel_appropriately_yes',
        'inp_2_5_3_assign_personnel_appropriately_no',
        'inp_2_5_3_training_need_assessment_yes',
        'inp_2_5_3_training_need_assessment_no',
        'inp_2_5_3_facility_and_environment_control_yes',
        'inp_2_5_3_facility_and_environment_control_no',
        'inp_2_5_3_equipment_maintenance_calibration_yes',
        'inp_2_5_3_equipment_maintenance_calibration_no',
        'inp_2_5_3_metrology_traceability_yes',
        'inp_2_5_3_metrology_traceability_no',
        'inp_2_5_3_external_product_service_control_yes',
        'inp_2_5_3_external_product_service_control_no',
        'inp_2_5_3_other',
        'inp_2_5_3_text_other1',
        'inp_2_5_3_text_other2',
        'inp_2_5_3_issue_found',
        'inp_2_5_3_detail',

        // 2.5.4
        'inp_2_5_4_structure_compliance',
        'inp_2_5_4_policy_compliance_yes',
        'inp_2_5_4_policy_compliance_no',
        'inp_2_5_4_metrology_sampling_activity_yes',
        'inp_2_5_4_metrology_sampling_activity_no',
        'inp_2_5_4_procedure_review_request_yes',
        'inp_2_5_4_procedure_review_request_no',
        'inp_2_5_4_decision_rule_yes',
        'inp_2_5_4_decision_rule_no',
        'inp_2_5_4_agreement_customer_yes',
        'inp_2_5_4_agreement_customer_no',
        'inp_2_5_4_method_verification_yes',
        'inp_2_5_4_method_verification_no',
        'inp_2_5_4_sample_management_yes',
        'inp_2_5_4_sample_management_no',
        'inp_2_5_4_record_management_yes',
        'inp_2_5_4_record_management_no',
        'inp_2_5_4_uncertainty_evaluation_yes',
        'inp_2_5_4_uncertainty_evaluation_no',
        'inp_2_5_4_result_surveillance_yes',
        'inp_2_5_4_result_surveillance_no',
        'inp_2_5_4_proficiency_testing_yes',
        'inp_2_5_4_proficiency_testing_no',
        'inp_2_5_4_test_participation',
        'inp_2_5_4_test_participation_details1',
        'inp_2_5_4_test_participation_details2',
        'inp_2_5_4_test_calibration',
        'inp_2_5_4_calibration_details',
        'inp_2_5_4_acceptance_criteria_yes',
        'inp_2_5_4_acceptance_criteria_no',
        'inp_2_5_4_acceptance_criteria1',
        'inp_2_5_4_acceptance_criteria2',
        'inp_2_5_4_lab_comparison',
        'inp_2_5_4_lab_comparison_details1',
        'inp_2_5_4_lab_comparison_details2',
        'inp_2_5_4_lab_comparison_test',
        'inp_2_5_4_lab_comparison_test_details',
        'inp_2_5_4_lab_comparison_test_is_accept_yes',
        'inp_2_5_4_lab_comparison_test_is_accept_no',
        'inp_2_5_4_lab_comparison_test_is_accept_details1',
        'inp_2_5_4_lab_comparison_test_is_accept_details2',
        'inp_2_5_4_test_participation2',
        'inp_2_5_4_other_methods',
        'inp_2_5_4_other_methods_details1',
        'inp_2_5_4_other_methods_details2',
        'inp_2_5_4_report_approval_review_yes',
        'inp_2_5_4_report_approval_review_no',
        'inp_2_5_4_decision_rule2_yes',
        'inp_2_5_4_decision_rule2_no',
        'inp_2_5_4_document_for_criteria_yes',
        'inp_2_5_4_document_for_criteria_no',
        'inp_2_5_4_complaint_process_yes',
        'inp_2_5_4_complaint_process_no',
        'inp_2_5_4_complaint_number',
        'inp_2_5_4_non_conformance_process_yes',
        'inp_2_5_4_non_conformance_process_no',
        'inp_2_5_4_non_conformance_number',
        'inp_2_5_4_data_control_yes',
        'inp_2_5_4_data_control_no',
        'inp_2_5_4_data_transfer_control_yes',
        'inp_2_5_4_data_transfer_control_no',
        'inp_2_5_4_other',
        'inp_2_5_4_text_other1',
        'inp_2_5_4_text_other2',
        'inp_2_5_4_issue_found',
        'inp_2_5_4_detail',

         // 2.5.5
        'inp_2_5_5_structure_compliance',
        'inp_2_5_5_data_control_option_a',
        'inp_2_5_5_data_control_option_b',
        'inp_2_5_5_data_control_policy_yes',
        'inp_2_5_5_data_control_policy_no',
        'inp_2_5_5_document_control_yes',
        'inp_2_5_5_document_control_no',
        'inp_2_5_5_record_keeping_yes',
        'inp_2_5_5_record_keeping_no',
        'inp_2_5_5_risk_management_yes',
        'inp_2_5_5_risk_management_no',
        'inp_2_5_5_risk_opportunity_yes',
        'inp_2_5_5_risk_opportunity_no',
        'inp_2_5_5_improvement_opportunity_yes',
        'inp_2_5_5_improvement_opportunity_no',
        'inp_2_5_5_non_conformance_yes',
        'inp_2_5_5_non_conformance_no',
        'inp_2_5_5_internal_audit_yes',
        'inp_2_5_5_internal_audit_no',
        'inp_2_5_5_audit_frequency',
        'inp_2_5_5_last_audit_date',
        'inp_2_5_5_audit_issues',
        'inp_2_5_5_management_review_yes',
        'inp_2_5_5_management_review_no',
        'inp_2_5_5_last_review_date',
        'inp_2_5_5_other',
        'inp_2_5_5_text_other1',
        'inp_2_5_5_text_other2',
        'inp_2_5_5_issue_found',
        'inp_2_5_5_detail',

        // 2.5.6.1.1
        'inp_2_5_6_1_1_management_review_no',
        'inp_2_5_6_1_1_management_review_yes',
        'inp_2_5_6_1_1_scope_certified_no',
        'inp_2_5_6_1_1_scope_certified_yes',
        'inp_2_5_6_1_1_activities_not_certified_yes',
        'inp_2_5_6_1_1_activities_not_certified_no',
        'inp_2_5_6_1_1_accuracy_yes',
        'inp_2_5_6_1_1_accuracy_no',
        'inp_2_5_6_1_1_accuracy_detail',

        // 2.5.6.1.2
        'inp_2_5_6_1_2_multi_site_display_no',
        'inp_2_5_6_1_2_multi_site_display_yes',
        'inp_2_5_6_1_2_multi_site_scope_no',
        'inp_2_5_6_1_2_multi_site_scope_yes',
        'inp_2_5_6_1_2_multi_site_activities_not_certified_yes',
        'inp_2_5_6_1_2_multi_site_activities_not_certified_no',
        'inp_2_5_6_1_2_multi_site_accuracy_yes',
        'inp_2_5_6_1_2_multi_site_accuracy_no',
        'inp_2_5_6_1_2_multi_site_accuracy_details',

        // 2.5.6.1.3
        'inp_2_5_6_1_3_certification_status_yes',
        'inp_2_5_6_1_3_certification_status_no',
        'inp_2_5_6_1_3_certification_status_details',

        // 2.5.6.1.4
        'inp_2_5_6_1_4_display_other_no',
        'inp_2_5_6_1_4_display_other_yes',
        'inp_2_5_6_1_4_display_other_details',
        'inp_2_5_6_1_4_certification_status_yes',
        'inp_2_5_6_1_4_certification_status_no',
        'inp_2_5_6_1_4_certification_status_details',

        // 6.2
        'inp_2_5_6_2_lab_availability_yes',
        'inp_2_5_6_2_lab_availability_no',

        // 6.2.1
        'inp_2_5_6_2_1_ilac_mra_display_no',
        'inp_2_5_6_2_1_ilac_mra_display_yes',
        'inp_2_5_6_2_1_ilac_mra_scope_no',
        'inp_2_5_6_2_1_ilac_mra_scope_yes',
        'inp_2_5_6_2_1_ilac_mra_disclosure_yes',
        'inp_2_5_6_2_1_ilac_mra_disclosure_no',
        'inp_2_5_6_2_1_ilac_mra_compliance_yes',
        'inp_2_5_6_2_1_ilac_mra_compliance_no',
        'inp_2_5_6_2_1_ilac_mra_compliance_details',

        // 6.2.2
        'inp_2_5_6_2_2_ilac_mra_compliance_no',
        'inp_2_5_6_2_2_ilac_mra_compliance_yes',
        'inp_2_5_6_2_2_ilac_mra_compliance_details',
        'inp_2_5_6_2_2_mra_compliance_yes',
        'inp_2_5_6_2_2_mra_compliance_no',
        'inp_2_5_6_2_2_mra_compliance_details',

        // 3.0
        'inp_3_0_assessment_results',
        'inp_3_0_issue_count',
        'inp_3_0_remarks_count',
        'inp_3_0_deficiencies_details',
        'inp_3_0_deficiency_resolution_date',
        'inp_3_0_offer_agreement',

        'file',
        'file_client_name',
        'persons',
        'status',
        'notified_signers'
    ];

    public function notice(){
        return $this->belongsTo(Notice::class, 'app_certi_lab_notice_id', 'id');
    }
}
