<?php

namespace App\Models\Certificate;

use DB;
use HP;
use App\User;
use App\AttachFile;
use App\CertificateExport;
use App\Models\Basic\Staff;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;
use App\Models\Certify\MessageRecordTrackingTransaction;
use App\Models\Bcertify\BoardAuditorTrackingMsRecordInfo;


class  Tracking extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking";
    protected $primaryKey = 'id';
    protected $fillable = ['certificate_type', 'reference_refno', 'ref_table', 'ref_id', 'status_id','tax_id','user_id','agent_id'];


    public function certificate_export_to()
    {
        if($this->certificate_type == 1){
            return $this->belongsTo(CertiCBExport::class,'ref_id','id');
         }else if($this->certificate_type == 2){
            return $this->belongsTo(CertiIBExport::class,'ref_id','id');
        }else{
            return $this->belongsTo(CertificateExport::class,'ref_id','id');
        }
    }



    // start เจ้าหน้าที่ได้รับมอบหมาย
    public function assigns_to(){
        return $this->belongsTo(TrackingAssigns::class,'id','tracking_id');
    }
    public function assigns_many(){
        return $this->hasMany(TrackingAssigns::class,'tracking_id','id');
    }
    public function getAssignNameAttribute() {
            $datas = [];
            if(count($this->assigns_many) > 0){  // เจ้าหน้าที่มอบหมาย
                $assigns = HP::getArrayFormSecondLevel($this->assigns_many->toArray(), 'user_id');
                foreach ($assigns as $key => $item) {
                    $users = Staff::where('runrecno', $item)->value(DB::raw("CONCAT(reg_fname,' ',reg_lname)"));
                    if(!is_null($users)){
                        $datas[] = $users;
                    }
                }
            }
        return $datas;
    }

    public function getAssignEmailsAttribute() {
        $datas = [];
    if(count($this->assigns_many) > 0){  // เจ้าหน้าที่มอบหมาย
        $assigns = HP::getArrayFormSecondLevel($this->assigns_many->toArray(), 'user_id');
            foreach ($assigns as $key => $item) {
            $users = Staff::where('runrecno', $item)->value('reg_email');
            if(!is_null($users) && !in_array($users,$datas)){
                $datas[] = $users;
            }
            }
        }
    return $datas;
    }

 



    public function tracking_status()
    {
    return $this->belongsTo(TrackingStatus::class,'status_id');
    }


    // start ประวัติคำขอรับใบรับรองหน่วยรับรอง
    public function history_many(){
        return $this->hasMany(TrackingHistory::class,'tracking_id') ->orderBy('id', 'desc');
    }
    // end ประวัติคำขอรับใบรับรองหน่วยรับรอง
  
    public function AuditorsManyBy()
    {
        return $this->hasMany(TrackingAuditors::class,'tracking_id','id')->orderBy('id', 'asc');
    }
  
    public function auditors_status_cancel_many()
    {
        return $this->hasMany(TrackingAuditors::class,'tracking_id','id')->whereNull('status_cancel') ->whereIn('step_id',[7,9]) ->orderBy('id', 'desc');
    }
    public function CertiAuditorsNullMany()
    {
        return $this->hasMany(TrackingAuditors::class,'tracking_id','id')->whereNull('status')->orderBy('id', 'asc');
    }


    public function tracking_payin_one_many()
    {
        return $this->hasMany(TrackingPayInOne::class,'tracking_id','id')->whereNotNull('conditional_type')->orderBy('id', 'asc');
    }
  
 
    public function tracking_assessment_many()
    {
        return $this->hasMany(TrackingAssessment::class,'tracking_id','id')->orderBy('id', 'asc');
    }
    public function tracking_save_assessment_many()
    {
        return $this->hasMany(TrackingAssessment::class,'tracking_id','id')->whereNotIn('degree',[0])->orderby('id','desc');
    }
     
     
    public function tracking_inspection_to()
    {
        return $this->belongsTo(TrackingInspection::class,'id','tracking_id')->orderBy('id', 'desc');
    }
    public function tracking_report_to()
    {
        return $this->belongsTo(TrackingReport::class,'id','tracking_id')->orderBy('id', 'desc');
    }
    public function tracking_review_to()
    {
        return $this->belongsTo(TrackingReview::class,'id','tracking_id')->orderBy('id', 'desc');
    }
  
    public function tracking_payin_two_to()
    {
        return $this->belongsTo(TrackingPayInTwo::class,'id','tracking_id')->orderBy('id', 'desc');
    }
    
 
    
    public function getCertiAuditorsStatusAttribute() {
          $list = '';
          $datas= HP::getArrayFormSecondLevel($this->AuditorsManyBy->toArray(), 'id');
          $status = TrackingAuditors::whereIn('id', $datas)->where('reference_refno',$this->reference_refno)->pluck('status')->toArray();  // ทั้งหมด
      
           $status1 = array_filter($status, function($v, $k) {
              return $v == 1;
          }, ARRAY_FILTER_USE_BOTH);
      
          $status2 = array_filter($status, function($v, $k) {
              return $v == 2;
          }, ARRAY_FILTER_USE_BOTH);
          if(count($status1) == count($status)){  // ผ่านทั้งหมด
              $list = "statusInfo";
          }elseif(count($status2) > 0){
              $list = "statusSuccess";
          }else{
              $list = "statusDanger";
          }
          return $list;
        }
      
        public function getCertiPayInOneStatusAttribute() {
          $data = HP::getArrayFormSecondLevel($this->tracking_payin_one_many->toArray(), 'id');
          $list = '';
          $states = TrackingPayInOne::whereIn('id', $data)->where('reference_refno',$this->reference_refno)->pluck('state')->toArray();
          $state1 = array_filter($states, function($v, $k) { // เจ้าหน้าที่ ส่ง มา
                              return $v == 1;
                          }, ARRAY_FILTER_USE_BOTH);
          $state2 = array_filter($states, function($v, $k) {  // ผู้ประกอบการ  ส่ง เจ้าหน้าที่
                              return $v == 2;
                          }, ARRAY_FILTER_USE_BOTH);
          $state3 = array_filter($states, function($v, $k) { // ผ่านการชำระ
                              return $v == 3 ;
                          }, ARRAY_FILTER_USE_BOTH);
      
            if(count($states) == count($state3)){
                   $list = "state3";
             }else if(count($state1) > 0){
                  $list = "state1";
             } else if(count($state2) > 0){
                   $list = "state2";
             }
          return $list;
        }
      
        public function getCertiSaveAssessmentStatusAttribute() {
          $list = '';
      
          $data = HP::getArrayFormSecondLevel($this->tracking_save_assessment_many->toArray(), 'id');
      
          $data_degree = TrackingAssessment::whereIn('id', $data)->pluck('degree')->toArray();  // ทั้งหมด
          $receive = TrackingAssessment::whereIn('id', $data)->whereIn('degree',[2,5,7])->pluck('degree')->toArray();//  จำนวน ผปก. ส่งไปให้
          $sent = TrackingAssessment::whereIn('id', $data)->whereIn('degree',[1,3,6])->pluck('degree')->toArray();// จำนวน จนท. ส่งไปให้
           // สถานะส่งไปให้ ผปก.
           $degree7 = array_filter($data_degree, function($v, $k) {
              return $v == 4 || $v == 7;
          }, ARRAY_FILTER_USE_BOTH);
          $degree8 = array_filter($data_degree, function($v, $k) {
              return $v == 8;
          }, ARRAY_FILTER_USE_BOTH);
          // ฉบับร่าง
          $degree0 = array_filter($data_degree, function($v, $k) {
              return $v == 0;
          }, ARRAY_FILTER_USE_BOTH);
      
          if(count($degree7) == count($data_degree)){  // ผ่านทั้งหมด
              $list = "statusInfo";
          }
          elseif(count($sent) > 0){  // จำนวน จนท. ส่งไปให้
              $list = "statusDanger";
          }
          elseif(count($receive) > 0){    //  จำนวน ผปก. ส่งไปให้
              $list = "statusSuccess";
          }
          elseif(count($degree8) > 0){  // จำนวน จนท. ส่งไปให้
              $list = "statuPrimary";
          }
          return $list;
        }
      


        public function fullyApprovedAuditorNoCancels()
        {
            return $this->AuditorsManyBy()
             ->whereNull('status_cancel')
             ->whereDoesntHave('messageRecordTrackingTransactions', function ($query) {
                 $query->where('approval', 0);
             }
            );
        }

}
