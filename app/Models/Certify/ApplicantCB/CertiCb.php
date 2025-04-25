<?php

namespace App\Models\Certify\ApplicantCB;

use HP;

use App\RoleUser;
use App\Models\Basic\Staff;
use App\Models\Basic\Amphur;
use App\Models\Basic\District;
use App\Models\Basic\Province;
use App\Models\Bcertify\Formula;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Sso\User AS SSO_User;
use App\Models\Certificate\CbTrustMark;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CertificationBranch;
use App\Models\Certificate\CbDocReviewAuditor;
use App\Models\Certify\CertiEmailLt;  //E-mail
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantCB\CertiCBStatus;

class CertiCb extends Model
{
    use Sortable;
    protected $connection = 'mysql';
    protected $table = "app_certi_cb";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_no',
                            'applicanttype_id',
                            'name',
                            'tax_id',
                            'cb_name',
                            'start_date',
                            'status',
                            'standard_change',
                            'app_certi_cb_export_id',
                            'accereditation_no',
                            'type_standard',
                            'name_standard',
                            'branch_type',
                            'branch',
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
                            'details',
                            'desc_delete',
                            'review',
                            'token',
                            'save_date',
                            'checkbox_confirm',
                            'created_by',
                            'agent_id',
                            'updated_by',
                            'get_date',
                            'check_badge',
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
                            'cb_latitude',
                            'cb_longitude',
                            'cb_address_no_eng',
                            'cb_moo_eng',
                            'cb_soi_eng',
                            'cb_street_eng',
                            'cb_province_eng',
                            'cb_amphur_eng',
                            'cb_district_eng',
                            'cb_postcode_eng',
                            'name_en_standard',
                            'name_short_standard',
                            'petitioner_id',
                            'trust_mark_id',
                            'doc_auditor_assignment',
                            'doc_review_update',
                            'doc_review_reject',
                            'doc_review_reject_message',
                            'require_scope_update',
                            'scope_view_signer_id',
                            'scope_view_status',
                            ];


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
     return $this->belongsTo(CertiCBStatus::class,'status','id');
 }
 //มาตรฐาน
 public function FormulaTo()
 {
     return $this->belongsTo(Formula::class,'type_standard');
 }
  //สาขา มาตรฐาน
  public function CertiCBFormulasTo()
  {
      return $this->belongsTo(CertiCBFormulas::class,'petitioner');
  }

  //สาขา มาตรฐาน ใหม่
  public function certification_branch()
  {
      return $this->belongsTo(CertificationBranch::class,'petitioner');
  }

 // ประมาณการค่าใช้จ่าย
 public function CertiCBCosts()
 {
     return $this->hasMany(CertiCBCost::class, 'app_certi_cb_id');
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
       return $this->hasMany(CertiCBAuditors::class, 'app_certi_cb_id');
   }


   public function fullyApprovedAuditorNoCancels()
   {
       return $this->CertiAuditors()
        ->whereNull('status_cancel')
        ->whereDoesntHave('messageRecordTransactions', function ($query) {
            $query->where('approval', 0);
        });
   }

    // แต่งตั้งคณะผู้ตรวจประเมิน
   public function CertiAuditorsMany()
   {
       return $this->hasMany(CertiCBAuditors::class, 'app_certi_cb_id')
       ->whereNull('is_review_state')
       ->whereNull('status_cancel')
       ->orderby('id','desc');


   }


   public function getCertiAuditorsManyDocReviewAttribute()
   {
    // dd($this->id);
         return  CertiCBAuditors::where('app_certi_cb_id',$this->id)
         ->whereNotNull('is_review_state')
         ->whereNull('status')
         ->whereNull('status_cancel')
         ->get();
      // return $this->hasMany(CertiCBAuditors::class, 'app_certi_cb_id')->whereNull('status_cancel')->orderby('id','desc');
   }

   public function CertiAuditorsNullMany()
   {
       return $this->hasMany(CertiCBAuditors::class, 'app_certi_cb_id')->whereNull('status')->orderby('id','desc');
   }
   // แจ้งรายละเอียดค่าตรวจประเมิน
   public function CertiCBPayInOneTo()
   {
       return $this->belongsTo(CertiCBPayInOne::class,'id','app_certi_cb_id')->orderby('id','desc');
   }

   public function CertiCBPayInOneMany()
   {
       return $this->hasMany(CertiCBPayInOne::class,'app_certi_cb_id')->whereNotNull('state')->orderby('id','desc');
   }

   //เช็ค หมายเตุ Pay in ครั้งที่ 1
   public function CertiCBPayInOneRemarkNotNullMany()
   {
       return $this->hasMany(CertiCBPayInOne::class,'app_certi_cb_id')->whereNotNull('remark')->orderby('id','desc');
   }
     // แจ้งรายละเอียดค่าตรวจประเมิน
     public function CertiCBSaveAssessments()
     {
         return $this->hasMany(CertiCBSaveAssessment::class, 'app_certi_cb_id')->orderby('id','desc');
     }

        public function getLogPassInspectionTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->LogPassInspection->toArray(), 'ref_id');
        $datas = CertiCBSaveAssessment::whereIn('id', $data)->get();
        return $datas;
      }
   // สรุปรายงานและเสนออนุกรรมการฯ
   public function CertiCBReportTo()
   {
       return $this->belongsTo(CertiCBReport::class,'id', 'app_certi_cb_id')->orderby('id','desc');
   }


 public function FileAttach1()
 {
     $tb = new CertiCb;
     return $this->hasMany(CertiCBAttachAll::class, 'app_certi_cb_id')->where('table_name',$tb->getTable())->where('file_section',1)->whereNull('ref_id');
 }

 public function FileAttach2()
 {
    $tb = new CertiCb;
     return $this->hasMany(CertiCBAttachAll::class, 'app_certi_cb_id')->where('table_name',$tb->getTable())->where('file_section',2)->whereNull('ref_id');
 }
 public function FileAttach3()
 {
    $tb = new CertiCb;
     return $this->hasMany(CertiCBAttachAll::class, 'app_certi_cb_id')->where('table_name',$tb->getTable())->where('file_section',3)->whereNull('ref_id');
 }
 public function FileAttach4()
 {
    $tb = new CertiCb;
     return $this->hasMany(CertiCBAttachAll::class, 'app_certi_cb_id')->where('table_name',$tb->getTable())->where('file_section',4)->whereNull('ref_id');
 }
 public function FileAttach5()
 {
    $tb = new CertiCb;
     return $this->hasMany(CertiCBAttachAll::class, 'app_certi_cb_id')->where('table_name',$tb->getTable())->where('file_section',5)->whereNull('ref_id');
 }
  // ขอเอกสารเพิ่มเติม
  public function FileAttach6()
  {
     $tb = new CertiCb;
      return $this->hasMany(CertiCBAttachAll::class, 'app_certi_cb_id')->where('table_name',$tb->getTable())->where('file_section',6)->whereNull('ref_id');
  }

  public function DataCertiCbHistory()
  {
      return $this->hasMany(CertiCbHistory::class, 'app_certi_cb_id');
  }

  public function CertiCBChecks() {
    return $this->hasMany(CertiCBCheck::class, 'app_certi_cb_id');
  }
  public function CertiCBSaveAssessmentMany()
  {
      return $this->hasMany(CertiCBSaveAssessment::class,'app_certi_cb_id')->whereNotIn('degree',[0])->orderby('id','desc');
  }

    // ตารางใบรับรอง
    public function app_certi_cb_export()
    {
        return $this->hasOne(CertiCBExport::class, 'app_certi_cb_id');
    }
        // แนบใบ Pay-in ครั้งที่ 2
    public function CertiCBPayInTwoTo()
    {
        return $this->belongsTo(CertiCBPayInTwo::class,'id','app_certi_cb_id')->orderby('id','desc');
    }

   // Mail แจ้งเตือน ผก. +  เจ้าหน้าที่มอบหมาย
  public function getCertifyEmailStaffAttribute() {
    $datas = [];
        $Staff = Staff::select('runrecno','reg_email')->whereIn('reg_subdepart',[1803])->get();
        if(count($Staff) > 0){
            foreach ($Staff as $key => $item) {
                $role_user = RoleUser::where('user_runrecno',$item->runrecno)
                                    ->where('role_id',31)
                                    ->first();
                if(!is_null($role_user)){
                    $datas[] = $item->reg_email ;
                }
            }
        }
        if(count($this->CertiCBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $examiner = HP::getArrayFormSecondLevel($this->CertiCBChecks->toArray(), 'user_id');
            $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
             foreach ($Staffs as $key => $item) {
                if(!is_null($item)){
                   $datas[] = $item;
                }
             }
         }
        //  if(!is_null($this->status) && (in_array($this->status,['11','12'])) ){ //e-mail ลท.
        //     $datas[] = 'souethai.pan@spumail.net';
        //  }
        //   $datas[] = 'tisipermit@gmail.com';
      return $datas;
  }

  public function basic_province() {
    return $this->belongsTo(Province::class, 'province_id');
 }

   //e-mail   Mail แจ้งเตือน ผก. + ลท.
   public function getCertiEmailDirectorAndLtAttribute() {
    $datas = [];
        $Staff = Staff::select('runrecno','reg_email')->whereIn('reg_subdepart',[1803])->get();
        if(count($Staff) > 0){
            foreach ($Staff as $key => $item) {
                $role_user = RoleUser::where('user_runrecno',$item->runrecno)
                                    ->where('role_id',31)
                                    ->first();
                if(!is_null($role_user)){
                    $datas[] = $item->reg_email ;
                }
            }
        }
        $email = CertiEmailLt::select('emails')->whereIn('certi',[2])->get();
        if(count($email) > 0){
            foreach ($email as $key => $item) {
                if(!is_null($item)){
                    $datas[] = $item->emails ;
                }
            }
        }
      return $datas;
  }
     //e-mail  เจ้าหน้าที่มอบหมาย + ลท.
     public function getCertiEmailStaffAndLtAttribute() {
        $datas = [];
        if(count($this->CertiCBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $examiner = HP::getArrayFormSecondLevel($this->CertiCBChecks->toArray(), 'user_id');
            $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
             foreach ($Staffs as $key => $item) {
                if(!is_null($item)){
                    $datas[] = $item;
                }
             }
         }
         $email = CertiEmailLt::select('emails')->whereIn('certi',[2])->get();
         if(count($email) > 0){    //e-mail ลท.
             foreach ($email as $key => $item) {
                 if(!is_null($item)){
                     $datas[] = $item->title ;
                 }
             }
         }
          return $datas;
      }

   //e-mail ลท.
  public function getCertiEmailLtTitleAttribute() {
    $datas = [];
        $email = CertiEmailLt::select('emails')->whereIn('certi',[2])->get();
        if(count($email) > 0){
            foreach ($email as $key => $item) {
                if(!is_null($item)){
                    $datas[] = $item->emails ;
                }
            }
        }
      return $datas;
  }


//<!----------------->
  // mail    ผก. +  เจ้าหน้าที่มอบหมาย
  public function getDataEmailDirectorCBAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->whereIn('certi',[1803])->whereIn('roles',[1])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
    if(count($this->CertiCBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->CertiCBChecks->toArray(), 'user_id');
        $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
         foreach ($Staffs as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item;
            }
         }
     }
      return $datas;
  }

  public function getDataEmailDirectorCBCCAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->where('cc',1)->whereIn('certi',[1803])->whereIn('roles',[1])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
    if(count($this->CertiCBChecks) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->CertiCBChecks->toArray(), 'user_id');
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
    $email = CertiEmailLt::select('emails')->whereIn('certi',[1803])->whereIn('roles',[2])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
      return $datas;
  }

  public function getDataEmailAndLtCBCCAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->whereIn('certi',[1803])->whereIn('roles',[1,2])->get();
    if(count($email) > 0){       // ลท.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
      return $datas;
  }

//<!----------------->


  public function getCertificationBranchNameAttribute() {
        return $this->certification_branch->title??'n/a';
  }



  public function getCertiAuditorsStatusAttribute() {
    $list = '';
    $datas= HP::getArrayFormSecondLevel($this->CertiAuditorsMany->toArray(), 'id');
    $status = CertiCBAuditors::whereIn('id', $datas)->pluck('status')->toArray();  // ทั้งหมด

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
  public function getCertiCBAuditorsStatusAttribute() {
    $data = HP::getArrayFormSecondLevel($this->CertiAuditors->toArray(), 'id');
    $list = '';
    $datas = CertiCBAuditors::whereIn('id', $data)->pluck('status')->toArray();
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
  public function getCertiCBPayInOneStatusAttribute() {
    $data = HP::getArrayFormSecondLevel($this->CertiCBPayInOneMany->toArray(), 'id');
    $list = '';
    $states = CertiCBPayInOne::whereIn('id', $data)->pluck('state')->toArray();
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

    public function getCertiCBSaveAssessmentStatusAttribute() {
        $list = '';

        $data = HP::getArrayFormSecondLevel($this->CertiCBSaveAssessmentMany->toArray(), 'id');

        $data_degree = CertiCBSaveAssessment::whereIn('id', $data)->pluck('degree')->toArray();  // ทั้งหมด
        $receive = CertiCBSaveAssessment::whereIn('id', $data)->whereIn('degree',[2,5,7])->pluck('degree')->toArray();//  จำนวน ผปก. ส่งไปให้
        $sent = CertiCBSaveAssessment::whereIn('id', $data)->whereIn('degree',[1,3,4,6])->pluck('degree')->toArray();// จำนวน จนท. ส่งไปให้
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

    public function certificationBranch(){
        return $this->belongsTo(CertificationBranch::class, 'petitioner_id');
      }

      public function cbTrustMark(){
        return $this->belongsTo(CbTrustMark::class, 'trust_mark_id');
      }

      public function cbDocReviewAuditor()
      {
          return $this->hasOne(CbDocReviewAuditor::class, 'app_certi_cb_id');
      }

}
