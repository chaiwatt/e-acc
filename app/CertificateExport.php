<?php

namespace App;

use App\Models\Certify\Applicant\CertiLab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
use HP;
class CertificateExport extends Model
{

    use SoftDeletes;
    protected $table = "certificate_exports";
    protected $primaryKey = 'id';
    protected $fillable = ['request_number','lang','certificate_no','status','certificate_order','certificate_for',
                            'org_name','lab_name','address_no',     'address_moo','address_soi', 'address_road','address_province', 'address_district', 
                            'address_subdistrict', 'address_postcode','formula',
                            // 'accereditatio_no_en',
                            'accereditatio_no', 'certificate_date_start','certificate_date_end', 'certificate_date_first', 'issue_no', 'scope_permanent',
                            'scope_site', 'scope_temporary', 'scope_mobile', 'attachs', 'lab_type', 'radio_address','attachs_client_name',
                            'title_en','lab_name_en','address_no_en','address_moo_en','address_soi_en','address_road_en','address_province_en','address_district_en','address_subdistrict_en','formula_en',
                            'sign_id', 'sign_name', 'sign_position', 'sign_instead',
                            'cer_type','certificate_path','certificate_file','certificate_newfile','documentId','signtureid','status_revoke','date_revoke','reason_revoke','user_revoke','reference_refno','reference_check','reference_date','status_id',
                            'review','contact_name','contact_tel','contact_mobile','contact_email','hold_status'
                        ];

    public function CertiLabTo()
    {
        // return $this->belongsTo(CertiLab::class,'certificate_for');
        return $this->belongsTo(CertiLab::class, 'certificate_for', 'id');
    }

    public function applications()
    {
        return $this->belongsTo(CertiLab::class,'certificate_for');
    }

    public function getTraderNameAttribute()
    {
        $cer = CertiLab::find($this->certificate_for);
        return $cer->trader->trader_operater_name;
    }

    public function getLabTypeNameAttribute()
    {
        if ($this->lab_type == '2'){
            $text   = "IB";
        }elseif ($this->lab_type == '1'){
            $text   = "CB";
        }elseif ($this->lab_type == '3'){
            $text   = "Lab ทดสอบ";
        }elseif ($this->lab_type == '4'){
            $text   = "Lab สอบเทียบ";
        }else{
            $text   = "N/A";
        }

        return $text;
    }

    public function getStatusTextAttribute()
    {
        if ($this->status == 0){
            return "จัดทำใบรับรอง";
        }elseif ($this->status == 1){
            return "ตรวจสอบความถูกต้อง";
        }elseif ($this->status == 2){
            return "ออกใบรับรองและลงนาม";
        }elseif ($this->status == 3){
            return "ลงนามเรียบร้อย";
        }else{
            return "N/A";
        }
    }

    
 public function tracking_status()
 {
     return $this->belongsTo(TrackingStatus::class,'status_id');
 }
    public function assigns_many(){
        return $this->hasMany(TrackingAssigns::class,'ref_id','id')->where('ref_table',$this->table)->where('certificate_type',3);
    }

    // start ประวัติคำขอรับใบรับรองห้องปฏิบัติการ
    public function history_many(){
        return $this->hasMany(TrackingHistory::class,'ref_id','id')->where('ref_table',$this->table)->where('certificate_type',3)->groupBy('reference_refno')->orderBy('id', 'asc');
    }
    // end ประวัติคำขอรับใบรับรองห้องปฏิบัติการ
    public function AuditorsManyBy()
    {
        return $this->hasMany(TrackingAuditors::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno)->where('certificate_type',3)->orderBy('id', 'asc');
    }
    public function CertiAuditorsNullMany()
    {
        return $this->hasMany(TrackingAuditors::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno)->whereNull('status')->where('certificate_type',3)->orderBy('id', 'asc');
    }

    public function auditors_status_cancel_many()
    {
        return $this->hasMany(TrackingAuditors::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',3)->whereNull('status_cancel') ->orderBy('id', 'desc');
    }



    public function tracking_payin_one_many()
    {
        return $this->hasMany(TrackingPayInOne::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno)->where('certificate_type',3)->whereNotNull('conditional_type')->orderBy('id', 'asc');
    }

    public function tracking_assessment_many()
    {
        return $this->hasMany(TrackingAssessment::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',3)->whereNotNull('degree')->orderBy('id', 'asc');
    }
 
    public function tracking_save_assessment_many()
    {
        return $this->hasMany(TrackingAssessment::class,'ref_id','id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',3)->whereNotIn('degree',[0])->orderby('id','desc');
    }

    public function tracking_inspection_to()
    {
        return $this->belongsTo(TrackingInspection::class,'id','ref_id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',3)->orderBy('id', 'desc');
    }
    public function tracking_report_to()
    {
        return $this->belongsTo(TrackingReport::class,'id','ref_id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',3)->orderBy('id', 'desc');
    }
    public function tracking_payin_two_to()
    {
        return $this->belongsTo(TrackingPayInTwo::class,'id','ref_id')->where('ref_table',$this->table)->where('reference_refno',$this->reference_refno )->where('certificate_type',3)->orderBy('id', 'desc');
    }
    
 
      // mail    ผก. +  เจ้าหน้าที่มอบหมาย
    public function getDataEmailDirectorLABAttribute() {
        $subgroup  =  $this->CertiLabTo->subgroup ?? 0;   
        $datas = [];
        $email = CertiEmailLt::select('emails')->where('certi',$subgroup)->whereIn('roles',[1])->get();
        if(count($email) > 0){       // ผก.
            foreach ($email as $key => $item) {
                if(!is_null($item)){
                    $datas[$item->emails] = $item->emails ;
                }
            }
        }
        if(count($this->assigns_many) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $assigns = HP::getArrayFormSecondLevel($this->assigns_many->toArray(), 'user_id');
            $staff = Staff::whereIn('runrecno', $assigns)->pluck('reg_email')->toArray();
            foreach ($staff as $key => $list) {
                if(!is_null($list)){
                   $datas[$list] = $list;
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
