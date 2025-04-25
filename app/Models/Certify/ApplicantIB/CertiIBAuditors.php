<?php

namespace App\Models\Certify\ApplicantIB;

use HP;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\MessageRecordTransaction;

class CertiIBAuditors  extends Model
{
    protected $table = 'app_certi_ib_auditors';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id',
                            'no',
                            'auditor',
                             'vehicle',
                            'status',
                            'remark',
                            'created_by',
                            'updated_by','ib_auditor_team_id','message_record_status'
                          ];
   
 public function CertiIBCostTo()
 {
     return $this->belongsTo(CertiIb::class,'app_certi_ib_id');
 }
   
 public function UserTo()
 {
     return $this->belongsTo(User::class,'created_by','runrecno');
 }   
 public function CertiIBAuditorsDates()
 {
     return $this->hasMany(CertiIBAuditorsDate::class, 'auditors_id');
 }

 
 public function CertiIBAuditorsCosts()
 {
     return $this->hasMany(CertiIBAuditorsCost::class, 'auditors_id');
 }
 
 public function CertiIBAuditorsLists()
 {
     return $this->hasMany(CertiIBAuditorsList::class, 'auditors_id');
 }
 public function CertiIbHistorys()
 {
     $tb = new CertiIBAuditors;
     return $this->hasMany(CertiIbHistory::class, 'ref_id')
               ->where('table_name',$tb->getTable()) 
               ->where('system',5);
 }

 public function FileAuditors1()
 {
    $tb = new CertiIBAuditors;
    return $this->belongsTo(CertiIBAttachAll::class,'id','ref_id')
                ->select('id','file')
                ->where('table_name',$tb->getTable())
                ->where('file_section',1);
 }  
 public function FileAuditors2()
 {
    $tb = new CertiIBAuditors;
    return $this->belongsTo(CertiIBAttachAll::class,'id','ref_id')
                ->select('id','file')
                ->where('table_name',$tb->getTable())
                ->where('file_section',2);
 }    
 
 
 public function getCertiIBAuditorsDateTitleAttribute() {
    $data = HP::getArrayFormSecondLevel($this->CertiIBAuditorsDates->toArray(), 'id');
    $datas = CertiIBAuditorsDate::select('start_date','end_date')->whereIn('id', $data)->get();
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
                }else{
                    $datas[$key] =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
                }
            }else{
                $datas[$key] =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
            }
         }
    }
    return implode(", ", json_decode($datas,true));
  }
    //  สถานะขั้นตอนการทำงาน
    public function CertiIBAuditorsStepTo()
    {
        return $this->belongsTo(CertiIBAuditorsStep::class,'step_id');
    }

    public function messageRecordTransactions()
    {
        return $this->hasMany(MessageRecordTransaction::class, 'board_auditor_id')->where('certificate_type',1);
    }
}
