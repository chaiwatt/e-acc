<?php

namespace App\Models\Certify;

use HP;
use App\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\BoardAuditorDate;
use App\Models\Certify\CertificateHistory;
use App\Models\Certify\BoardAuditorHistory;
use App\Models\Certify\Applicant\CertiLabStep;
use App\Models\Certify\MessageRecordTransaction;
use App\Models\Bcertify\BoardAuditorMsRecordInfo;

class BoardAuditor extends Model
{
    use Sortable;
    
    protected $table = "board_auditors";
    protected $primaryKey = 'id';
    protected $fillable = ['certi_no','app_certi_lab_id', 'no', 'check_date', 'check_end_date', 'file', 'attach','created_by', 'updated_by','status','state','vehicle','status_cancel',
    'reason_cancel','created_cancel','date_cancel','attach_client_name','file_client_name','step_id','auditor','message_record_status'];
    protected $dates = ['check_date','check_end_date'];

    public function user_created(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function certi_lab_step_to(){
        return $this->belongsTo(CertiLabStep::class, 'step_id');
    }


    public function groups() {
        return $this->hasMany(BoardAuditorGroup::class, 'board_auditor_id');
    }
    public function DataBoardAuditorDate() {
        return $this->hasMany(BoardAuditorDate::class, 'board_auditors_id','id');
    }
    //ประวัติ
    public function CertificateHistorys() {
        $ao = new BoardAuditor;
        return $this->hasMany(CertificateHistory::class,'ref_id', 'id')->where('table_name',$ao->getTable());
    }
    public function BoardAuditorHistorys() {
        return $this->hasMany(BoardAuditorHistory::class, 'board_auditor_id','id');
    }
    public function getDataBoardAuditorDateTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->DataBoardAuditorDate->toArray(), 'id');
        $datas = BoardAuditorDate::select('start_date','end_date')->whereIn('id', $data)->get();
        $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        foreach ($datas as $key => $list) {
              if(!is_null($list->start_date) &&!is_null($list->end_date)){
                 // ปี
                 $StartYear = date("Y", strtotime($list->start_date)) +543;
                 $EndYear = date("Y", strtotime($list->end_date)) +543;
                // เดือน
                $StartMonth= date("n", strtotime($list->start_date));
                $EndMonth= date("n", strtotime($list->end_date));
                //วัน
                $StartDay= date("j", strtotime($list->start_date));
                $EndDay= date("j", strtotime($list->end_date));
                if($StartYear == $EndYear){
                    if($StartMonth == $EndMonth){
                          if($StartDay == $EndDay){
                            $datas[$key] =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear ;
                          }else{
                            $datas[$key] =  $StartDay.'-'.$EndDay.' '.$strMonthCut[$StartMonth].' '.$StartYear ;
                          }
                    }
                }else{
                    $datas[$key] =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
                }
             }
        }
        return implode("<br/>", json_decode($datas,true));
      }
    public function auditor_information() {
        return $this->hasManyThrough(
            BoardAuditorInformation::class,
            BoardAuditorGroup::class,
            'board_auditor_id',
            'group_id'
        );
    }

    public function messageRecordTransactions()
    {
        return $this->hasMany(MessageRecordTransaction::class, 'board_auditor_id', 'id');
    }

    public function pendingApprovalTransactions()
    {
        return $this->messageRecordTransactions()->where('approval', 0);
    }
    public function boardAuditorMsRecordInfos()
    {
        return $this->hasMany(BoardAuditorMsRecordInfo::class, 'board_auditor_id', 'id');
    }
}
