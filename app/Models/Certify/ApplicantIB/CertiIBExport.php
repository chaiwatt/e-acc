<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

use App\Models\Certificate\TrackingAuditors;
use App\Models\Certificate\TrackingAssigns; 
use App\Models\Certificate\TrackingHistory;  
use App\Models\Certificate\TrackingPayInOne;
use App\Models\Certificate\TrackingAssessment; 
use App\Models\Certificate\TrackingInspection; 
use App\Models\Certificate\TrackingReport;
use App\Models\Certificate\TrackingPayInTwo;
use App\Models\Certificate\TrackingStatus;
use App\Models\Certify\CertiEmailLt;  //E-mail ลท.
use App\Models\Basic\Staff;
class CertiIBExport extends Model
{
    protected $table = 'app_certi_ib_export';
    protected $primaryKey = 'id';
    protected $fillable = [
							              'org_name',
                            'app_certi_ib_id', //TB: app_certi_cb
                            'type_standard',
                            'type_unit',
                            'app_no',
                            'certificate',
                            'radio_address',
                            'name_unit',
                            'address',
                            'allay',
                            'village_no',
                            'road',
                            'province_name',
                            'amphur_name',
                            'district_name',
                            'postcode',
                            'formula',
                            'attachs',
                            'status',
                            'accereditatio_no',
                            'accereditatio_no_en',
                            'date_start',
                            'date_end',
                            'created_by',
                            'updated_by' ,
                            'name_en','name_unit_en','address_en','allay_en','village_no_en','road_en','province_name_en','amphur_name_en','district_name_en','formula_en',
                            'attach_client_name',
                            'cer_type','certificate_path','certificate_file','certificate_newfile','documentId','signtureid','status_revoke','date_revoke','reason_revoke','user_revoke',
                            'reference_refno','reference_check','reference_date', 'status_id'
                            ];
public function CertiIBCostTo()
 {
     return $this->belongsTo(CertiIb::class,'app_certi_ib_id');
 }
      
 public function UserTo()
 {
     return $this->belongsTo(User::class,'created_by','runrecno');
 }   
 public function getStatusTitleAttribute() {
    $list = '';
      if($this->status == 19){
        $list =  'ลงนามเรียบร้อย';
      }else{
        $list =  'ออกใบรับรอง และ ลงนาม';
      }
      return  $list ?? '-';
  }
  
  public function tracking_status()
  {
      return $this->belongsTo(TrackingStatus::class,'status_id');
  }
     public function assigns_many(){
         return $this->hasMany(TrackingAssigns::class,'ref_id','id')->where('ref_table',$this->table)->where('certificate_type',2);
     }
 
     // start ประวัติคำขอรับใบรับรองหน่วยตรวจ
     public function history_many(){
         return $this->hasMany(TrackingHistory::class,'ref_id','id')->where('ref_table',$this->table)->where('certificate_type',2)->groupBy('reference_refno')->orderBy('id', 'asc');
     }
     // end ประวัติคำขอรับใบรับรองหน่วยตรวจ
     public function AuditorsManyBy()
     {
         return $this->hasMany(TrackingAuditors::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno)->where('certificate_type',2)->orderBy('id', 'asc');
     }
     public function CertiAuditorsNullMany()
     {
         return $this->hasMany(TrackingAuditors::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno)->whereNull('status')->where('certificate_type',2)->orderBy('id', 'asc');
     }
 
     public function auditors_status_cancel_many()
     {
         return $this->hasMany(TrackingAuditors::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->whereNull('status_cancel') ->orderBy('id', 'desc');
     }
 
 
 
     public function tracking_payin_one_many()
     {
         return $this->hasMany(TrackingPayInOne::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno)->where('certificate_type',2)->whereNotNull('conditional_type')->orderBy('id', 'asc');
     }
 
     public function tracking_assessment_many()
     {
         return $this->hasMany(TrackingAssessment::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->whereNotNull('degree')->orderBy('id', 'asc');
     }
  
     public function tracking_save_assessment_many()
     {
         return $this->hasMany(TrackingAssessment::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->whereNotIn('degree',[0])->orderby('id','desc');
     }
 
     public function tracking_inspection_to()
     {
         return $this->belongsTo(TrackingInspection::class,'id','ref_id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->orderBy('id', 'desc');
     }
     public function tracking_report_to()
     {
         return $this->belongsTo(TrackingReport::class,'id','ref_id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->orderBy('id', 'desc');
     }
     public function tracking_payin_two_to()
     {
         return $this->belongsTo(TrackingPayInTwo::class,'id','ref_id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->orderBy('id', 'desc');
     }



 
  // mail    ผก. +  เจ้าหน้าที่มอบหมาย
  public function getDataEmailDirectorIBAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->whereIn('certi',[1802])->whereIn('roles',[1])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
    if(count($this->assigns_many) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->assigns_many->toArray(), 'user_id');
        $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
         foreach ($Staffs as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item;
            }
         }
     }
      return $datas;
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
 
  
}
