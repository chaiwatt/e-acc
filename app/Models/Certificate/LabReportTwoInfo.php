<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\Notice;

class LabReportTwoInfo extends Model
{
    use Sortable;
    protected $table = 'lab_report_two_infos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_notice_id',
        
        // 2.2
        'inp_2_2_assessment_on_site_chk',
        'inp_2_2_assessment_at_tisi_chk',
        'inp_2_2_remote_assessment_chk',
        'inp_2_2_self_declaration_chk',
        'inp_2_2_bug_fix_evidence_chk',

        //2.4 
        'inp_2_4_defects_and_remarks_text',
        'inp_2_4_doc_reference_date_text',
        'inp_2_4_doc_sent_date1_text',
        'inp_2_4_doc_sent_date2_text',
        'inp_2_4_lab_bug_fix_completed_chk',
        'inp_2_4_fix_approved_chk',
        'inp_2_4_approved_text',
        'inp_2_4_remain_text',

        //3.0
        'inp_3_lab_fix_all_issues_chk',
        'inp_3_lab_fix_some_issues_chk',
        'inp_3_approved_text',
        'inp_3_remain_text',
        'inp_3_lab_fix_failed_issues_chk',
        'inp_3_lab_fix_failed_issues_yes_chk',
        'inp_3_lab_fix_failed_issues_no_chk',

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
