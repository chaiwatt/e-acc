<?php

namespace App\Models\Certify\ApplicantCB;

use HP;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\MessageRecordTransaction;

class CertiCBAuditors  extends Model
{
    protected $table = 'app_certi_cb_auditors';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id',
                            'no',
                            'vehicle',
                             'auditor',
                             'status',
                            'state',
                            'step_id',
                            'created_by',
                            'updated_by',
                            'is_review_state',
                              'message_record_status',
                               'cb_auditor_team_id'
                          ];
   
 public function CertiCbCostTo()
 {
     return $this->belongsTo(CertiCb::class,'app_certi_cb_id');
 }
   
 public function UserTo()
 {
     return $this->belongsTo(User::class,'created_by','runrecno');
 }   
 public function CertiCBAuditorsDates()
 {
     return $this->hasMany(CertiCBAuditorsDate::class, 'auditors_id');
 }

 
 public function CertiCBAuditorsCosts()
 {
     return $this->hasMany(CertiCBAuditorsCost::class, 'auditors_id');
 }
 
 public function CertiCBAuditorsLists()
 {
     return $this->hasMany(CertiCBAuditorsList::class, 'auditors_id');
 }
 public function CertiCbHistorys()
 {
     $tb = new CertiCBAuditors;
     return $this->hasMany(CertiCbHistory::class, 'ref_id')
               ->where('table_name',$tb->getTable()) 
               ->where('system',5);
 }

 public function FileAuditors1()
 {
    $tb = new CertiCBAuditors;
    return $this->belongsTo(CertiCbAttachAll::class,'id','ref_id')
                ->select('id','file')
                ->where('table_name',$tb->getTable())
                ->where('file_section',1);
 }  
 public function FileAuditors2()
 {
    $tb = new CertiCBAuditors;
    return $this->belongsTo(CertiCbAttachAll::class,'id','ref_id')
                ->select('id','file')
                ->where('table_name',$tb->getTable())
                ->where('file_section',2);
 }    
 
 
 public function getCertiCBAuditorsDateTitleAttribute() {
    $data = HP::getArrayFormSecondLevel($this->CertiCBAuditorsDates->toArray(), 'id');
    $datas = CertiCBAuditorsDate::select('start_date','end_date')->whereIn('id', $data)->get();
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

  public function getSumCostConFirmAttribute() {
    $data = $this->CertiCBAuditorsCosts;
    $countItem = 0;
    if(count($data) > 0){
        foreach($data as $item){
            $countItem += $item->amount * $item->amount_date;
        }
    }
    return number_format($countItem,2) ?? 0;
   }

    //  สถานะขั้นตอนการทำงาน
   public function CertiCBAuditorsStepTo()
   {
       return $this->belongsTo(CertiCBAuditorsStep::class,'step_id');
   }

   
   public function messageRecordTransactions()
   {
       return $this->hasMany(MessageRecordTransaction::class, 'board_auditor_id', 'id');
   }

}
