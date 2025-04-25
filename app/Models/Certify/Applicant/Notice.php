<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use  App\Models\Certify\BoardAuditor;
use App\Models\Certify\CertificateHistory;
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
        return $this->hasMany(CertificateHistory::class,'ref_id', 'id')->where('system',4)->where('table_name',$ao->getTable());
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
}
