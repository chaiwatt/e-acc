<?php

namespace App\Models\Certify\ApplicantIB;

use HP;
use App\RoleUser;
use App\Models\Basic\Staff;
use App\Models\Basic\Amphur;

use App\Models\Esurv\Trader;
use App\Models\Basic\District;
use App\Models\Basic\Province;
use App\Models\Bcertify\Formula;
use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Models\Sso\User AS SSO_User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\IbDocReviewAuditor;
use App\Models\Certify\ApplicantIB\CertiIBExport;
use App\Models\Certify\CertiEmailLt;  //E-mail ลท.

class CertiIb extends Model
{
    use Sortable;

    protected $table = "app_certi_ib";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_no',
                            'applicanttype_id',
                            'name',
                            'status',
                            'standard_change',
                            'type_unit',
                            'name_unit',
                            'branch',
                            'branch_type',
                            'type_standard',
                            'app_certi_ib_export_id',
                            'accereditation_no',
                             'checkbox_address',
                             'address',
                             'allay',
                             'village_no',
                             'road',
                             'province_id',
                             'amphur_id',
                             'district_id',
                             'postcode',
                             'tel',
                             'tel_fax',
                             'contactor_name',
                             'email',
                             'contact_tel',
                             'telephone',
                             'petitioner',
                             'desc_delete',
                             'review',
                             'token',
                             'date',
                             'checkbox_confirm',
                             'created_by', //tb10_nsw_lite_trader
                             'agent_id',
                             'updated_by',
                             'start_date',
                             'tax_id',
                             'hq_address',
                             'hq_moo',
                             'hq_soi',
                             'hq_road',
                             'hq_subdistrict_id',
                             'hq_district_id',
                             'hq_province_id',
                             'hq_zipcode',
                             'hq_date_registered',
                             'hq_telephone',
                             'hq_fax',
             
                             'ib_latitude', 
                             'ib_longitude', 
             
                             'name_en_unit',
                             'name_short_unit',
             
                             'ib_address_no_eng',
                             'ib_moo_eng',
                             'ib_soi_eng',
                             'ib_street_eng',
                             'ib_province_eng',
                             'ib_amphur_eng',
                             'ib_district_eng',
                             'ib_postcode_eng',
                             'doc_auditor_assignment',
                             'doc_review_update',
                             'doc_review_reject',
                             'doc_review_reject_message',
                             'require_scope_update',
                             'scope_view_signer_id',
                             'scope_view_status',
                            ];

    // TEXT  หน่วยตรวจประเภท
    public function getTypeUnitTitleAttribute() {
        $datas = ['1'=>'A','2'=>'B','3'=>'C'];
          return array_key_exists($this->type_unit,$datas) ? $datas[$this->type_unit] : '';
      }

   public function EsurvTrader()
 {
     return $this->belongsTo(Trader::class,'created_by','trader_autonumber');
 }

 public function BasicProvince()
 {
     return $this->belongsTo(Province::class,'province_id','PROVINCE_ID');
 }
 public function BasicAmphur()
 {
     return $this->belongsTo(Amphur::class,'amphur_id','AMPHUR_ID');
 }
 public function BasicDistrict()
 {
     return $this->belongsTo(District::class,'district_id','DISTRICT_ID');
 }

 public function TitleStatus()
 {
     return $this->belongsTo(CertiIBStatus::class,'status','id');
 }

 public function CertiIBChecks() {
    return $this->hasMany(CertiIBCheck::class, 'app_certi_ib_id');
}

 // ประมาณการค่าใช้จ่าย
 public function CertiIBCosts()
 {
     return $this->hasMany(CertiIBCost::class, 'app_certi_ib_id');
 }
   // แต่งตั้งคณะผู้ตรวจประเมิน
 public function CertiIBAuditorsMany()
 {
     return $this->hasMany(CertiIBAuditors::class,'app_certi_ib_id')->whereNull('status_cancel')->orderby('id','desc');
 }
 public function CertiAuditorsNullMany()
 {
     return $this->hasMany(CertiIBAuditors::class, 'app_certi_ib_id')->whereNull('status');
 }

 public function fullyApprovedAuditorNoCancels()
 {
     return $this->CertiAuditors()
      ->whereNull('status_cancel')
      ->whereDoesntHave('messageRecordTransactions', function ($query) {
          $query->where('approval', 0);
      });
 }

 public function fullyApprovedAuditors()
 {
     return $this->CertiAuditors()->whereDoesntHave('messageRecordTransactions', function ($query) {
         $query->where('approval', 0);
     });
 }

    // แต่งตั้งคณะผู้ตรวจประเมิน
    public function CertiAuditors()
    {
        return $this->hasMany(CertiIBAuditors::class, 'app_certi_ib_id');
    }
 

   // แจ้งรายละเอียดค่าตรวจประเมิน
   public function CertiIBPayInOneTo()
   {
       return $this->belongsTo(CertiIBPayInOne::class,'id','app_certi_ib_id')->orderby('id','desc');
   }
   public function CertiIBPayInOneMany()
    {
        return $this->hasMany(CertiIBPayInOne::class,'app_certi_ib_id')->whereNotNull('state')->orderby('id','desc');
    }
    public function CertiIBPayInOneRemarkNotNullMany()
    {
        return $this->hasMany(CertiIBPayInOne::class,'app_certi_ib_id')->whereNotNull('remark')->orderby('id','desc');
    }

   // แจ้งรายละเอียดค่าตรวจประเมิน
   public function CertiIBSaveAssessments()
   {
       return $this->hasMany(CertiIBSaveAssessment::class, 'app_certi_ib_id')->orderby('id','desc');
   }

   public function CertiIBReportTo()
   {
       return $this->belongsTo(CertiIBReport::class,'id', 'app_certi_ib_id')->orderby('id','desc');
   }
    // แนบใบ Pay-in ครั้งที่ 2
    public function CertiIBPayInTwoTo()
    {
        return $this->belongsTo(CertiIBPayInTwo::class,'id','app_certi_ib_id')->orderby('id','desc');
    }

   public function LogAssessment()
   {
        $tb = new CertiIBSaveAssessment;
       return $this->hasMany(CertiIbHistory::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('system',7);
   }
    // เช็คมี ผ่านการตรวจสอบประเมิน
    public function LogPassInspection()
    {
        $tb = new CertiIBSaveAssessment;
        return $this->hasMany(CertiIbHistory::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('system',8);
    }
    public function getLogPassInspectionTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->LogPassInspection->toArray(), 'ref_id');
        $datas = CertiIBSaveAssessment::whereIn('id', $data)->get();
        return $datas;
      }

 public function FileAttach1()
 {
     $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',1)->whereNull('ref_id');
 }

 public function FileAttach2()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',2)->whereNull('ref_id');
 }
 public function FileAttach3()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',3)->whereNull('ref_id');
 }
 public function FileAttach4()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',4)->whereNull('ref_id');
 }
 public function FileAttach5()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',5)->whereNull('ref_id');
 }
 public function FileAttach6()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',6)->whereNull('ref_id');
 }
 public function FileAttach7()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',7)->whereNull('ref_id');
 }
 public function FileAttach8()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',8)->whereNull('ref_id');
 }

 // จนท.
 public function FileAttach9()
 {
    $tb = new CertiIb;
     return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',9)->whereNull('ref_id');
 }
  // จนท
  public function FileAttach10()
  {
     $tb = new CertiIb;
      return $this->hasMany(CertiIBAttachAll::class, 'app_certi_ib_id')->where('table_name',$tb->getTable())->where('file_section',10)->whereNull('ref_id');
  }

  public function DataCertiIbHistory()
  {
     $tb = new CertiIb;
      return $this->hasMany(CertiIbHistory::class, 'app_certi_ib_id');
  }

    // คารางใบรับรอง
    public function app_certi_ib_export()
    {
        return $this->hasOne(CertiIBExport::class, 'app_certi_ib_id');
    }


 public function getCertifyEmailStaffAttribute() {
    $datas = [];
        $Staff = Staff::select('runrecno','reg_email')->whereIn('reg_subdepart',[1802])->get();
        if(count($Staff) > 0){
            foreach ($Staff as $key => $item) {
                $role_user = RoleUser::where('user_runrecno',$item->runrecno)
                                    ->where('role_id',30)
                                    ->first();
                if(!is_null($role_user)){
                   $datas[] = $item->reg_email ;
                }
            }
        }
        if(count($this->CertiIBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $examiner = HP::getArrayFormSecondLevel($this->CertiIBChecks->toArray(), 'user_id');
            $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
             foreach ($Staffs as $key => $item) {
                if(!is_null($item)){
                    $datas[] = $item;
                }
             }
         }
           //e-mail ลท.
            // $datas[] = 'chaiviehit.tisi@gmail.com';

      return $datas;
  }

   //e-mail   Mail แจ้งเตือน ผก. + ลท.
   public function getCertiEmailDirectorAndLtAttribute() {
    $datas = [];
        $Staff = Staff::select('runrecno','reg_email')->whereIn('reg_subdepart',[1802])->get();
        if(count($Staff) > 0){
            foreach ($Staff as $key => $item) {
                $role_user = RoleUser::where('user_runrecno',$item->runrecno)
                                    ->where('role_id',30)
                                    ->first();
                if(!is_null($role_user)){
                    $datas[] = $item->reg_email ;
                }
            }
        }
        $email = CertiEmailLt::select('emails')->whereIn('certi',[3])->get();
        if(count($email) > 0){
            foreach ($email as $key => $item) {
                if(!is_null($item)){
                    $datas[] = $item->emails ;
                }
            }
        }
      return $datas;
  }
     //e-mail ลท.
     public function getCertiEmailLtTitleAttribute() {
        $datas = [];
            $email = CertiEmailLt::select('emails')->whereIn('certi',[3])->get();
            if(count($email) > 0){
                foreach ($email as $key => $item) {
                    if(!is_null($item)){
                        $datas[] = $item->emails ;
                    }
                }
            }
          return $datas;
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
    if(count($this->CertiIBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->CertiIBChecks->toArray(), 'user_id');
        $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
         foreach ($Staffs as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item;
            }
         }
     }
      return $datas;
  }

  public function getDataEmailDirectorIBCCAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->where('cc',1)->whereIn('certi',[1802])->whereIn('roles',[1])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
    if(count($this->CertiIBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->CertiIBChecks->toArray(), 'user_id');
        $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
         foreach ($Staffs as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item;
            }
         }
     }
      return $datas;
  }

   //e-mail   ลท.
   public function getCertiEmailLtAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->whereIn('certi',[1802])->whereIn('roles',[2])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
      return $datas;
  }

  public function getDataEmailAndLtIBCCAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->whereIn('certi',[1802])->whereIn('roles',[1,2])->get();
    if(count($email) > 0){       // ลท.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }

    // if(count($this->CertiIBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
    //     $examiner = HP::getArrayFormSecondLevel($this->CertiIBChecks->toArray(), 'user_id');
    //     $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
    //      foreach ($Staffs as $key => $item) {
    //         if(!is_null($item)){
    //             $datas[] = $item;
    //         }
    //      }
    //  }
      return $datas;
  }



//   public function getDataEmailDirectorIBReplyToAttribute() {
//     $datas = [];
//     $email = CertiEmailLt::select('emails')->where('reply_to',1)->whereIn('certi',[1802])->whereIn('roles',[1])->get();
//     if(count($email) > 0){       // ผก.
//         foreach ($email as $key => $item) {
//             if(!is_null($item)){
//                 $datas[] = $item->emails ;
//             }
//         }
//     }
//     if(count($this->CertiIBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
//         $examiner = HP::getArrayFormSecondLevel($this->CertiIBChecks->toArray(), 'user_id');
//         $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
//          foreach ($Staffs as $key => $item) {
//             if(!is_null($item)){
//                 $datas[] = $item;
//             }
//          }
//      }
//       return $datas;
//   }

//   public function getDataEmailDirectorIbReplToAttribute() {
//     $datas = [];
//     $email = CertiEmailLt::select('emails')->whereIn('certi',[1802])->whereIn('roles',[3])->get();
//     if(count($email) > 0){
//         foreach ($email as $key => $item) {
//             if(!is_null($item)){
//                 $datas[] = $item->emails ;
//             }
//         }
//     }
//       return $datas;
//   }



    public function getAddressIBAttribute() {
            $address = '';
        if(!is_null($this->address) && $this->address != ''){
            $address .=  ' เลขที่: '.$this->address;
        }
        if(!is_null($this->allay)  && $this->allay != ''){
            $address .=  ' หมู่ที่: '.$this->allay;
        }
        if(!is_null($this->village_no)){
            $address .=  ' ตรอก/ซอย: '.$this->village_no;
        }
        if(!is_null($this->road)  && $this->road != ''){
            $address .=  ' ถนน: '.$this->road;
        }

        if(!is_null($this->province_id)  && $this->province_id != ''){
            $address .=  ' จังหวัด: '. $this->BasicProvince->PROVINCE_NAME ?? '-';
        }
        if(!is_null($this->amphur_id)  && $this->amphur_id != ''){
            $address .=  ' เขต/อำเภอ: '.$this->BasicAmphur->AMPHUR_NAME ?? "";
        }

        if(!is_null($this->district_id)  && $this->district_id != ''){
            $address .=  ' แขวง/ตำบล: '.$this->BasicDistrict->DISTRICT_NAME  ?? '-';
        }
        if(!is_null($this->postcode)  && $this->postcode != ''){
            $address .=  ' รหัสไปรษณีย์: '.$this->postcode;
        }
        return $address;
    }

    public function getCertiAuditorsStatusAttribute() {
        $list = '';
        $datas= HP::getArrayFormSecondLevel($this->CertiIBAuditorsMany->toArray(), 'id');
        $status = CertiIBAuditors::whereIn('id', $datas)->pluck('status')->toArray();  // ทั้งหมด

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
    public function getCertiIBAuditorsStatusAttribute() {
        $data = HP::getArrayFormSecondLevel($this->CertiIBAuditorsMany->toArray(), 'id');
        $list = '';
        $datas = CertiIBAuditors::whereIn('id', $data)->pluck('status')->toArray();
    // สถานะส่งไปให้ ผปก.
        $statusNull = array_filter($datas, function($v, $k) {
                            return $v == null;
                        }, ARRAY_FILTER_USE_BOTH);
    // สถานะ  ผปก. เห็นด้วย
        $status1 = array_filter($datas, function($v, $k) {
                            return $v == 1;
                        }, ARRAY_FILTER_USE_BOTH);
    // สถานะ  ผปก. ไม่เห็นด้วย
        $status2 = array_filter($datas, function($v, $k) {
                            return $v == 2;
                        }, ARRAY_FILTER_USE_BOTH);
        if(count($statusNull) > 0 || count($datas) == 0){
                    $list = "StatusSent";
        }else{
            if(count($status2) > 0){
                    $list = "StatusNotView";
            }else{
                if(count($datas) == count($status1)){
                    $list = "StatusView";
                }else{
                    $list = "StatusNotView";
                }
            }
        }
        return $list;
    }
    public function getCertiIBPayInOneStatusAttribute() {
        $data = HP::getArrayFormSecondLevel($this->CertiIBPayInOneMany->toArray(), 'id');
        $list = '';
        $states = CertiIBPayInOne::whereIn('id', $data)->pluck('state')->toArray();
        $state1 = array_filter($states, function($v, $k) { // เจ้าหน้าที่ ส่ง มา
                            return $v == 1;
                        }, ARRAY_FILTER_USE_BOTH);
        $state2 = array_filter($states, function($v, $k) {  // ผู้ประกอบการ  ส่ง เจ้าหน้าที่
                            return $v == 2;
                        }, ARRAY_FILTER_USE_BOTH);
        $state3 = array_filter($states, function($v, $k) { // ผ่านการชำระ
                            return $v == 3;
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

    public function getCertiIBSaveAssessmentStatusAttribute() {
        $list = '';

        $data = HP::getArrayFormSecondLevel($this->CertiIBSaveAssessments->toArray(), 'id');

        $data_degree = CertiIBSaveAssessment::whereIn('id', $data)->pluck('degree')->toArray();  // ทั้งหมด
        $receive = CertiIBSaveAssessment::whereIn('id', $data)->whereIn('degree',[2,5,7])->pluck('degree')->toArray();//  จำนวน ผปก. ส่งไปให้
        $sent = CertiIBSaveAssessment::whereIn('id', $data)->whereIn('degree',[1,3,4,6])->pluck('degree')->toArray();// จำนวน จนท. ส่งไปให้
        // สถานะส่งไปให้ ผปก.
        $degree7 = array_filter($data_degree, function($v, $k) {
            return $v == 7;
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

    public function hq_province()
    {
        return $this->belongsTo(Province::class,'hq_province_id','PROVINCE_ID');
    }
    public function hq_district()
    {
        return $this->belongsTo(Amphur::class,'hq_district_id','AMPHUR_ID');
    }
    public function hq_subdistrict()
    {
        return $this->belongsTo(District::class,'hq_subdistrict_id','DISTRICT_ID');
    }

    public function getHqSubdistrictNameAttribute() {
        return !empty($this->hq_subdistrict)?$this->hq_subdistrict->DISTRICT_NAME:null;
    }

    public function getHqDistrictNameAttribute() {
        return !empty($this->hq_district)?$this->hq_district->AMPHUR_NAME:null;
    }

    public function getHqProvinceNameAttribute() {
        return !empty($this->hq_province)?$this->hq_province->PROVINCE_NAME:null;
    }

    public function user_created()
    {
        return $this->belongsTo(SSO_User::class, 'created_by');
    }

    // วันที่รับคำขอ
    public function getAcceptDateShowAttribute()
    {
        return !empty($this->save_date)?HP::DateThai($this->save_date):'-';
    }

    public function ibDocReviewAuditor()
    {
        return $this->hasOne(IbDocReviewAuditor::class, 'app_certi_ib_id');
    }

    public function FormulaTo()
    {
        return $this->belongsTo(Formula::class,'type_standard');
    }

}
