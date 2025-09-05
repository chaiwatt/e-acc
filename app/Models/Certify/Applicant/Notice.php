<?php

namespace App\Models\Certify\Applicant;

use Kyslik\ColumnSortable\Sortable;
use  App\Models\Certify\BoardAuditor;
use App\Models\Certify\LabReportInfo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\CertificateHistory;
use App\Models\Certificate\LabReportTwoInfo;
use App\Models\Certify\SignAssessmentReportTransaction;

class Notice extends Model
{
    use Sortable;

    protected $table = "app_certi_lab_notices";
    protected $fillable = ['app_certi_assessment_id','app_certi_lab_id','assessment_date','step','file','attachs','evidence','remark','file_scope','file_car',
    'draft','status','report_status','group','desc','auditor_id','submit_type','expert_token','accept_fault','notice_duration','notice_confirm_date'];
    protected $dates = [
        'assessment_date',
    ];

    public function assessment() {
        return $this->belongsTo(Assessment::class, 'app_certi_assessment_id');
    }

    public function assessment_group() {
        return $this->belongsTo(AssessmentGroup::class, 'app_certi_assessment_group_id');
    }

    public function applicant() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }

    public function files() {
        return $this->hasMany(NoticeFile::class, 'app_certi_lab_notice_id');
    }

    public function items() {
        return $this->hasMany(NoticeItem::class, 'app_certi_lab_notice_id');
    }
    public function board_auditor_to() {
        return $this->belongsTo(BoardAuditor::class, 'auditor_id');
    }


    //ประวัติ
    public function CertificateHistorys() {
        $ao = new Notice;
        // dd($ao->getTable());
        return $this->hasMany(CertificateHistory::class,'ref_id', 'id')->where('system',4)->where('table_name',$ao->getTable());
     }


    public function getCertificateHistorys($certiLabId) {
        $ao = new Notice;
        // dd($ao->getTable());
        return CertificateHistory::where('ref_id', $this->id)
        ->where('system',4)
        ->where('table_name',$ao->getTable())
        ->where('app_certi_lab_id',$certiLabId)
        ->get();
     }






          //ประวัติ
    public function LogNotice() {
        $ao = new Notice;
        return $this->hasMany(CertificateHistory::class,'ref_id', 'id')->where('system',11)->where('table_name',$ao->getTable());
        }
    public function getStatus() {
        if ($this->draft == 1) {
            return "ฉบับร่าง";
        }

        if ($this->report_status == 1) {
            return "พบข้อบกพร่อง";
        }

        if ($this->status == 1) {
            return "ผ่าน";
        } else if ($this->status == 2) {
            return "ไม่ผ่าน";
        }

        return "ผิดพลาด";
    }

    public function getDataGroupeTitleAttribute() {
        $group =   json_decode($this->group,true);
        $groups = [];
        if(count($group) > 0) {
           foreach($group  as $key => $list){
            $auditors = BoardAuditor::select('id','no')->where('id',@$list)->groupBy('no')->orderby('id','desc')->first();
            if(!is_null($auditors)){
                $groups[$key] = $auditors->no;
            }
           }
        }
        return implode("<br>",$groups);
      }

    public function whatKindOfReport()
    {
        $report = LabReportInfo::where('app_certi_lab_notice_id',$this->id)->first();

        if($report == null){
            $report = LabReportTwoInfo::where('app_certi_lab_notice_id',$this->id)->first();
        }

        return  $report;
    }

    public function reportLabSigned($reportId)
    {
        $org = SignAssessmentReportTransaction::where('report_info_id', $reportId)
            ->where(function ($query) {
            $query->whereNotIn('template', ['ib_doc_review_template', 'cb_doc_review_template'])
                ->orWhereNull('template');
        })
        ->where('certificate_type', 2)
        ->where('app_id', CertiLab::find($this->app_certi_lab_id)->app_no)
        ->whereNotNull('signer_id')
        ->get();

        $signed = SignAssessmentReportTransaction::where('report_info_id', $reportId)
            ->where(function ($query) {
            $query->whereNotIn('template', ['ib_doc_review_template', 'cb_doc_review_template'])
                ->orWhereNull('template');
        })
        ->where('certificate_type', 2)
        ->where('app_id', CertiLab::find($this->app_certi_lab_id)->app_no)
        ->whereNotNull('signer_id')
        ->where('approval', 1)
        ->get();

        // dd($org->count() , $signed->count());

        if($org->count() != 0){
            if($org->count() == $signed->count()){
                return true;
            }else{
                return false;
            }
        }else
        {
            return false;
        }



                // dd( $remainingApprovals,$reportId,CertiLab::find($this->app_certi_lab_id)->app_no);

        return $remainingApprovals ;
    }
}
