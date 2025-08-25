<?php

namespace App\Models\Certify\Applicant;

use HP;

use App\RoleUser;
use Carbon\Carbon;
use App\CertificateExport;
use App\Models\Basic\Staff;
use App\Models\Basic\Amphur;
use App\Models\Esurv\Trader;
use App\Models\Basic\District;
use App\Models\Basic\Province;
use App\Models\Bcertify\Formula;
use Illuminate\Support\Facades\DB;
use App\Models\Bcertify\TestBranch;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Certify\BoardAuditor;
use App\Models\Sso\User AS SSO_User;
use App\Models\Bcertify\InspectBranch;
use App\Models\Bcertify\LabCalRequest;
use App\Models\Bcertify\LabTestRequest;
use App\Models\Certify\SetStandardUser;
use Illuminate\Database\Eloquent\Model;

use App\Models\Certify\Applicant\Report;
use App\Models\Bcertify\CalibrationBranch;

use App\Models\Bcertify\LabCalTransaction;
use App\Models\Certify\CertificateHistory;

use App\Models\Certify\SetStandardUserSub;
use App\Models\Bcertify\CertificationBranch;
use App\Models\Certify\Applicant\CheckExaminer;
use App\Models\Bcertify\LabRequestRejectTracking;
use App\Models\Bcertify\PurposeType;
use App\Models\Certify\Applicant\AssessmentGroup;
use App\Models\Certify\Applicant\CostCertificate;
use App\Models\Certify\CertiEmailLt;  //E-mail ลท.

class CertiLab extends Model
{
    use Sortable;

    protected $table = "app_certi_labs";
    protected $primaryKey = 'id';
    protected $fillable = [

                            'app_no',
                            'applicanttype_id',
                            'name',
                            'tax_id',
                            'purpose_type',
                            'standard_id',
                            'lab_type',
                            'certificate_exports_id',
                            'accereditation_no',
                            'type_standard',
                            'branch_name',
                            'branch_type',
                            'branch',
                            'lab_name',
                            'lab_name_en',
                            'start_date',
                            'same_address',
                            'address_no',
                            'allay',
                            'village_no',
                            'road',
                            'province',
                            'amphur',
                            'district',
                            'postcode',
                            'tel',
                            'tel_fax',
                            'contactor_name',
                            'email',
                            'contact_tel',
                            'telephone',
                            'management_lab',
                            'status',
                            'subgroup',
                            'trader_id',
                            'created_at',
                            'updated_at',
                            'created_by',
                            'agent_id',
                            'deleted_by',
                            'deleted_at',
                            'desc_delete',
                            'attach',
                            'attach_pdf',
                            'attach_pdf_client_name',
                            'checkbox_confirm',
                            'token',
                            'get_date',
                            'lab_latitude',
                            'lab_longitude',
                            'lab_name_en',
                            'lab_name_short',
                            'lab_address_no_eng',
                            'lab_moo_eng',
                            'lab_soi_eng',
                            'lab_street_eng',
                            'lab_province_eng',
                            'lab_amphur_eng',
                            'lab_district_eng',
                            'lab_postcode_eng',
                            'lab_ability',
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
                            'require_scope_update',
                            'scope_view_signer_id',
                            'scope_view_status',
                            'transferer_user_id',
                            'transferer_export_id'
                        ];

                      
    public function attach()
    {
        return $this->hasMany(CertiLabAttach::class, 'app_certi_lab_id');
    }

    public function get_this_attach_config($config_id)
    {
        $file = CertiLabAttach::where('app_certi_lab_id', $this->id)->where('config_attach_id', $config_id)->first();
        return $file ?? null;
    }

    public function CheckExaminers() {
        return $this->hasMany(CheckExaminer::class, 'app_certi_lab_id','id');
       }

    public function purposeType()
    {
        return $this->belongsTo(PurposeType::class, 'purpose_type');
    }   
       
    public function checkbox()
    {
        return $this->hasOne(CertiLabCheckBox::class, 'app_certi_lab_id');
    }

    public function employee()
    {
        return $this->hasMany(CertiLabEmployee::class, 'app_certi_lab_id');
    }

    public function info()
    {
        return $this->hasOne(CertiLabInfo::class, 'app_certi_lab_id');
    }

    public function material()
    {
        return $this->hasMany(CertiLabMaterialLef::class, 'app_certi_lab_id');
    }

    public function place()
    {
        return $this->hasOne(CertiLabPlace::class, 'app_certi_lab_id');
    }

    public function program()
    {
        return $this->hasMany(CertiLabProgram::class, 'app_certi_lab_id');
    }

    public function information()
    {
        return $this->hasOne(Information::class, 'app_certi_lab_id');
    }

    public function check()
    {
        return $this->hasOne(Check::class, 'app_certi_lab_id');
    }


    public function assessment()
    {
        return $this->hasOne(Assessment::class, 'app_certi_lab_id');
    }

    public function notices()
    {
        return $this->hasMany(Notice::class, 'app_certi_lab_id');
    }

    public function costs()
    {
        return $this->hasOne(Cost::class, 'app_certi_lab_id');
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'created_by');
    }
    public function CostCertificateTo()
    {
        return $this->belongsTo(CostCertificate::class, 'id','app_certi_lab_id')->orderby('id','desc');;
    }
    public function cost_assessment()
    {
        return $this->hasOne(CostAssessment::class, 'app_certi_lab_id');
    }
    public function CostAssessmentTo()
    {
        return $this->belongsTo(CostAssessment::class, 'id','app_certi_lab_id')->orderby('id','desc');;
    }

    public function BelongsInformation()
    {
        return $this->belongsTo(Information::class,'id','app_certi_lab_id');
    }
    // เช็คมี ข้อบกพร่อง/ข้อสังเกต หรือเปล่า
    public function LogNotice()
    {
        return $this->hasMany(CertificateHistory::class, 'app_no', 'app_no')->where('system',4);
    }

    public function getLogNoticeTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->LogNotice->toArray(), 'ref_id');
        $datas = Notice::whereIn('id', $data)->get();
        return $datas;
      }
    // เช็คมี ผ่านการตรวจสอบประเมิน
    public function LogPassInspection()
    {
        return $this->hasMany(CertificateHistory::class, 'app_no', 'app_no')->where('system',11);
    }
    public function getLogPassInspectionTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->LogPassInspection->toArray(), 'ref_id');
        $datas = Notice::whereIn('id', $data)->get();
        return $datas;
      }

    // เช็คมี  Pay IN ครั้งที่ 1 ชำระหรือยัง
    public function LogPayIN1()
    {
        return $this->hasMany(CertificateHistory::class, 'app_no', 'app_no')->where('system',3)->where('status',1);
    }
    public function getLogPayIN1TitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->LogPayIN1->toArray(), 'id');
        $datas = CertificateHistory::whereIn('id', $data)->pluck('details')->toArray();

        if(count($datas) > 0){
            foreach ($datas as $key => $item) {
                $details = json_decode($item);
                  foreach ($details as  $item1) {
                    $list[] =   number_format($item1->amount,2);
                  }
            }
         }
         return  isset($list) ? implode(',</br>', $list)  : '-' ;
      }

    public function certi_test_scope()
    {
        return $this->hasMany(CertifyTestScope::class, 'app_certi_lab_id');
    }
    public function getBranchTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->certi_test_scope->toArray(), 'branch_id');
        //  dd($this->certi_test_scope->toArray());
        // $datas = DB::table('bcertify_test_branches')->whereIn('id', $data)->pluck('title')->toArray();
        $datas = [];
        foreach ($data as $key => $list) {
            // dd($list);
            $branches = DB::table('bcertify_test_branches')->where('id',$list)->first() ;
            // dd($branches);
            if(!is_null($branches) && !is_null($branches->title)){
                $datas[$key] = $branches->title ?? '' ;
            }

        }
        return implode(', ', $datas);
      }

    public function certi_lab_calibrate()
    {
        return $this->hasMany(CertifyLabCalibrate::class, 'app_certi_lab_id');
    }
    public function getClibrateBranchTitleAttribute() {
        $data = HP::getArrayFormSecondLevel($this->certi_lab_calibrate->toArray(), 'branch_id');
        // $datas = DB::table('bcertify_calibration_branches')->whereIn('id', $data)->pluck('title')->toArray();
        $datas = [];
        foreach ($data as $key => $list) {
            $branches = DB::table('bcertify_calibration_branches')->where('id',$list)->first() ;
            if(!is_null($branches) && !is_null($branches->title)){
                $datas[$key] = $branches->title ?? '' ;
            }

        }
        return implode(', ', $datas);
      }
    public function certi_tools_test()
    {

        return $this->hasMany(CertiToolsTest::class, 'app_certi_lab_id');
    }

    public function certi_tools_calibrate()
    {
        return $this->hasMany(CertiToolsCalibrate::class, 'app_certi_lab_id');
    }

    public function get_standard()
    {
        return $this->hasOne(Formula::class, 'id', 'standard_id');
    }

    public function check_examiner() {
        return $this->hasMany(CheckExaminer::class, 'app_certi_lab_id');
    }

    public function assessment_examiner() {
        return $this->hasMany(AssessmentExaminer::class, 'app_certi_lab_id');
    }


    public function getCertifyEmailStaffAttribute() {
        $datas = [];
        if(!is_null($this->subgroup)){     //e-mail ผก.
            $Staff = Staff::select('runrecno','reg_email')->where('reg_subdepart',$this->subgroup)->get();
            if(count($Staff) > 0){
                foreach ($Staff as $key => $list) {
                    $role_user = RoleUser::where('user_runrecno',$list->runrecno)
                                        ->where('role_id',22)
                                        ->first();
                    if(!is_null($role_user)){
                        $datas[] = $list->reg_email ;
                    }
                }
            }
         }

         if(count($this->check_examiner) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $examiner = HP::getArrayFormSecondLevel($this->check_examiner->toArray(), 'user_id');
            $Staff = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
             foreach ($Staff as $key => $list) {
                if(!is_null($list)){
                   $datas[] = $list;
                }
             }
         }

          return $datas;
      }

       //e-mail  เจ้าหน้าที่มอบหมาย
      public function getCertifyEmailAuthoritiesAttribute() {
        $datas = [];
         if(count($this->check_examiner) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $examiner = HP::getArrayFormSecondLevel($this->check_examiner->toArray(), 'user_id');
            $Staff = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
             foreach ($Staff as $key => $list) {
                if(!is_null($list)){
                   $datas[] = $list;
                }
             }
         }
          return $datas;
      }

     //e-mail  เจ้าหน้าที่มอบหมาย + ลท.
     public function getCertiEmailStaffAndLtAttribute() {
        $datas = [];
        if(count($this->check_examiner) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
            $examiner = HP::getArrayFormSecondLevel($this->check_examiner->toArray(), 'user_id');
            $Staffs = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
             foreach ($Staffs as $key => $item) {
                if(!is_null($item)){
                    $datas[] = $item;
                }
             }
         }
         $email = CertiEmailLt::select('emails')->whereIn('certi',[1])->get();
         if(count($email) > 0){    //e-mail ลท.
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
            $email = CertiEmailLt::select('emails')->whereIn('certi',[1])->get();
            if(count($email) > 0){
                foreach ($email as $key => $item) {
                    if(!is_null($item)){
                        $datas[] = $item->emails ;
                    }
                }
            }
        return $datas;
    }


    //e-mail เจ้าหน้าที่มอบหมาย
    public function getExaminerEmailStaffAttribute() {
        $result = [];
        if(count($this->check_examiner) > 0){
            $data = HP::getArrayFormSecondLevel($this->check_examiner->toArray(), 'user_id');
            $datas = Staff::whereIn('runrecno', $data)->pluck('reg_email')->toArray();
             foreach ($datas as $key => $list) {
                 $result[] = $list ;
             }
        }
        return $result;
      }


//<!----------------->
  // mail    ผก. +  เจ้าหน้าที่มอบหมาย
  public function getDataEmailDirectorLABAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->where('certi',$this->subgroup)->whereIn('roles',[1])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[$item->emails] = $item->emails ;
            }
        }
    }
    if(count($this->check_examiner) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->check_examiner->toArray(), 'user_id');
        $Staff = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
         foreach ($Staff as $key => $list) {
            if(!is_null($list)){
               $datas[$list] = $list;
            }
         }
     }
      return $datas;
  }

  public function getDataEmailDirectorLABCCAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->where('cc',1)->where('certi',$this->subgroup)->whereIn('roles',[1])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[$item->emails] = $item->emails ;
            }
        }
    }
    if(count($this->check_examiner) > 0){  //e-mail เจ้าหน้าที่มอบหมาย
        $examiner = HP::getArrayFormSecondLevel($this->check_examiner->toArray(), 'user_id');
        $Staff = Staff::whereIn('runrecno', $examiner)->pluck('reg_email')->toArray();
         foreach ($Staff as $key => $list) {
            if(!is_null($list)){
               $datas[$list] = $list;
            }
         }
     }
      return $datas;
  }

   //e-mail   ลท.
   public function getCertiEmailLtAttribute() 
   {
    $datas = [];
    $email = CertiEmailLt::select('emails')->where('certi',$this->subgroup)->whereIn('roles',[2])->get();
    if(count($email) > 0){       // ผก.
        foreach ($email as $key => $item) {
            if(!is_null($item)){
                $datas[] = $item->emails ;
            }
        }
    }
      return $datas;
  }

  public function getDataEmailAndLtLABCCAttribute() {
    $datas = [];
    $email = CertiEmailLt::select('emails')->where('certi',$this->subgroup)->whereIn('roles',[1,2])->get();
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



    public function arrStatus()
    {
        return [
            '0'  => 'ฉบับร่าง',
            '1'  => 'รอดำเนินการตรวจสอบ',
            '2'  => 'อยู่ระหว่างการตรวจสอบ',
            '3'  => 'ขอเอกสารเพิ่มเติม',
            '4'  => 'ยกเลิกคำขอ',
            '5'  => 'ไม่ผ่านการตรวจสอบ',
            '6'  => 'ผ่านการตรวจสอบ',
            '7'  => 'รอชำระค่าธรรมเนียม',
            '8'  => 'แจ้งชำระค่าธรรมเนียม',
            '10' => 'ประมาณค่าใช้จ่าย',
            '9'  => 'รับคำขอ',
            '11' => 'ขอความเห็นประมาณค่าใช้จ่าย',
            '12' => 'แต่งตั้งคณะผู้ตรวจประเมิน',
            '13' => 'ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน',
            '14' => 'แจ้งรายละเอียดค่าตรวจประเมิน',
            '15' => 'ชำระเงินค่าตรวจประเมิน',
            '16' => 'ตรวจสอบการชำระค่าตรวจประเมิน',
            '18' => 'สรุปรายงานและเสนออนุกรรมการฯ',
            '19' => 'แจ้งรายละเอียดการชำระค่าใบรับรอง',
            '17' => 'ตรวจประเมิน',
            '20' => 'ชำระเงินค่าใบรับรอง',
            '21' => 'ตรวจสอบการชำระค่าใบรับรอง',
            '22' => 'ออกใบรับรอง',
            '23' => 'ยืนยันความถูกต้อง',
            '24' => 'แก้ไขใบรับรอง',
            '25' => 'ออกใบรับรองและลงนาม'
        ];
    }

    public function certi_lab_status_to()
    {
        return $this->belongsTo(CertiLabStatus::class,'status');
    }

    public function getStatus()
    {
        // $statusArr = $this->arrStatus();
        // return $statusArr[$this->status];
      return  !empty($this->certi_lab_status_to->title)   ? $this->certi_lab_status_to->title : null;
    }

    public function getPurposeType()
    {
        $purpose_type =['1'=>'ขอใบรับรอง','2'=>'ต่ออายุใบรับรอง','3'=>'ขยายขอบข่าย'];
        return  array_key_exists($this->purpose_type,$purpose_type)  ? $purpose_type[$this->purpose_type] : '-';
    }
    public function getLabType()
    {
        $lab_type =['3'=>'ทดสอบ','4'=>'สอบเทียบ'];
        return  array_key_exists($this->lab_type,$lab_type)  ? $lab_type[$this->lab_type] : '-';
    }


    public function getEmailAuthoritiesCertify() {
        $datas = [];
        // ทดสอบ
        $test_scope = HP::getArrayFormSecondLevel($this->certi_test_scope->toArray(), 'branch_id');
        if(count($test_scope)){
            $user_sub = SetStandardUserSub::whereIn('test_branch_id',$test_scope)->pluck('standard_user_id');
            if(count($user_sub)){
                $set_standard = SetStandardUser::whereIn('id',$user_sub)->pluck('sub_department_id');
                if(count($set_standard)){
                    $Staff = Staff::select('runrecno','reg_email')->whereIn('reg_subdepart',$set_standard)->get();
                    foreach ($Staff as $key => $list) {
                        $role_user = RoleUser::where('user_runrecno',$list->runrecno)
                                            ->where('role_id',22)
                                             ->first();
                        if(!is_null($role_user)){
                            $datas[$key] = $list->reg_email ;
                        }

                     }
                }
            }
         }

        //  สอบเทียบ
         $certi_lab = HP::getArrayFormSecondLevel($this->certi_lab_calibrate->toArray(), 'branch_id');
         if(count($certi_lab)){
             $user_sub = SetStandardUserSub::whereIn('items_id',$certi_lab)->pluck('standard_user_id');
             if(count($user_sub)){
                 $set_standard = SetStandardUser::whereIn('id',$user_sub)->pluck('sub_department_id');
                 if(count($set_standard)){
                     $Staff = Staff::select('runrecno','reg_email')->whereIn('reg_subdepart',$set_standard)->get();
                     foreach ($Staff as $key => $list) {
                         $role_user = RoleUser::where('user_runrecno',$list->runrecno)
                                             ->where('role_id',22)
                                              ->first();
                         if(!is_null($role_user)){
                             $datas[$key] = $list->reg_email ;
                         }

                      }
                 }
             }
          }
          return $datas;
      }

      public function certiLab_delete_file()
      {
          return $this->hasMany(CertiLabDeleteFile::class, 'app_certi_lab_id');
      }



    public function get_branch()
    {
        $branch_ob = $this->branch_name;
        $lab_type  = $this->lab_type; // ประเภทการตรวจ
        if ($lab_type == '2') {
            $branch = InspectBranch::whereId($branch_ob)->first();
        } elseif ($lab_type == '1') {
            $branch = CertificationBranch::whereId($branch_ob)->first();
        } elseif ($lab_type == '3') {
            $branch = TestBranch::whereId($branch_ob)->first();
        } elseif ($lab_type == '4') {
            $branch = CalibrationBranch::whereId($branch_ob)->first();
        }else {
            $branch = '';
        }
        return $branch;
    }

    public function get_branches($lab_type = null)
    {
        if ($lab_type == null) {
            $lab_type = $this->lab_type; // ประเภทการตรวจ
        }

        if ($lab_type == '2') {
            $branches = InspectBranch::get();
        } elseif ($lab_type == '1') {
            $branches = CertificationBranch::get();
        } elseif ($lab_type == '3') {
            $branches = TestBranch::get();
        } elseif ($lab_type == '4') {
            $branches = CalibrationBranch::get();
        }
        return $branches ?? collect();
    }

    public function assessment_type($ln = null)
    {
        $assessment_list = ['CB', 'IB', 'LAB', 'LAB'];
        if ($ln == "th") {
            $assessment_list = ['CB', 'IB', 'ทดสอบ', 'สอบเทียบ'];
        }
        $assessment = $this->lab_type - 1;
        return $assessment_list[$assessment] ?? 'error';
    }


    public function getSelectAuditors()
    {
        $group = $this->assessment->groups()->where('status', 1)->first();
        return $group;
    }

    public function TableAssessmentGroup()
    {
        return $this->belongsTo(AssessmentGroup::class ,'id','app_certi_lab_id' );
    }


    public function getInformationNameAttribute()
    {
        return $this->BelongsInformation->name??'n/a';
    }

    public function certificate_export_to()
    {
        return $this->belongsTo(CertificateExport::class ,'id','certificate_for' )->where('status',28)->where('status','>=',4);
    }

    public function certificate_exports_to()
    {
        // return $this->hasOne(CertificateExport::class, 'certificate_for');
        return $this->hasOne(CertificateExport::class, 'certificate_for', 'id');
    }

    public function getCertificateExport()
    {
        $certificateExport = CertificateExport::where('certificate_for',$this->id)->first();
        return $certificateExport;

    }

    public function report_to()
    {
        return $this->belongsTo(Report::class,'id','app_certi_lab_id');
    }


   //  start แต่งตั้งคณะผู้ตรวจประเมิน
   public function certi_auditors()
   {
       return $this->hasMany(BoardAuditor::class, 'app_certi_lab_id');
   }

//    public function fullyApprovedAuditors()
//    {
//        $fullyApprovedAuditors = [];
//        $approvedAuditorIds = [];
//         // dd(CertiLab::find($this->id));
//        // ดึง BoardAuditor ที่เชื่อมโยงกับ CertiLab ปัจจุบัน
//        $boardAuditors = BoardAuditor::where('app_certi_lab_id', $this->id)->get();
   
//        foreach ($boardAuditors as $boardAuditor) {
//            // ดึง MessageRecordTransaction ที่ approval = 0 ของ BoardAuditor ปัจจุบัน
//            $pendingTransactions = MessageRecordTransaction::where('board_auditor_id', $boardAuditor->id)
//                ->where('approval', 0)
//                ->get();
   
//            // ถ้าไม่มีรายการ approval = 0 แสดงว่าได้รับการอนุมัติทั้งหมด
//            if ($pendingTransactions->count() == 0) {
//                $approvedAuditorIds[] = $boardAuditor->id;
//            }
//        }

//        $approvedAuditors = BoardAuditor::whereNotIn('id',$approvedAuditorIds)->get();

//        return $approvedAuditors;
//    }
   
 
public function fullyApprovedAuditors()
{
    return $this->certi_auditors()->whereDoesntHave('messageRecordTransactions', function ($query) {
        $query->where('approval', 0);
    });
}
   public function certi_auditors_null_many()
   {
       return $this->hasMany(BoardAuditor::class, 'app_certi_lab_id')->whereNull('status')->orderby('id','desc');
   }
   public function fullyApprovedAuditorNoCancels()
   {
       return $this->certi_auditors()
        ->whereNull('status_cancel')
        ->whereDoesntHave('messageRecordTransactions', function ($query) {
            $query->where('approval', 0);
        });
   }

    public function certi_auditors_many()
    {
        return $this->hasMany(BoardAuditor::class,'app_certi_lab_id') ->whereNull('status_cancel')->orderby('id','desc');
    }
    
    public function getCertiAuditorsStatusAttribute() {
        $list = '';
        $datas= HP::getArrayFormSecondLevel($this->certi_auditors_many->toArray(), 'id');
        $status = BoardAuditor::whereIn('id', $datas)->pluck('status')->toArray();  // ทั้งหมด
    
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
   //  end แต่งตั้งคณะผู้ตรวจประเมิน

    //   start pay in ครั้งที่ 1
      public function cost_assessment_many()
      {
          return $this->hasMany(CostAssessment::class,'app_certi_lab_id')->whereNotNull('state')->orderby('id','desc');

      }
      public function getCertiLabPayInOneStatusAttribute() {
        $data = HP::getArrayFormSecondLevel($this->cost_assessment_many->toArray(), 'id');
        $list = '';
        $states = CostAssessment::whereIn('id', $data)->pluck('state')->toArray();
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
    //   end pay in ครั้งที่ 1

      public function getCertiLabSaveAssessmentStatusAttribute() {
        $list = '';

        $data = HP::getArrayFormSecondLevel($this->notices->toArray(), 'id');

        $data_degree = Notice::whereIn('id', $data)->pluck('degree')->toArray();  // ทั้งหมด
        $receive = Notice::whereIn('id', $data)->whereIn('degree',[2,5,7])->pluck('degree')->toArray();//  จำนวน ผปก. ส่งไปให้
        $sent = Notice::whereIn('id', $data)->whereIn('degree',[1,3,4,6])->pluck('degree')->toArray();// จำนวน จนท. ส่งไปให้
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
        return !empty($this->get_date)?HP::DateThai($this->get_date):'-';
    }

    public function province_to()
    {
        return $this->belongsTo(Province::class,'province','PROVINCE_ID');
    }
    public function province_eng_to()
    {
        return $this->belongsTo(Province::class,'lab_province_eng','PROVINCE_ID');
    }
    

    // ขอบข่าย
    public function Certi_Lab_State1_FileTo()
    {
        return $this->belongsTo(CertLabsFileAll::class,'id','app_certi_lab_id')->where('state',1);
    }
    // เช็คขอบข่ายใน mapreq
    public function certi_lab_export_mapreq_to()
    {
        return $this->belongsTo(CertiLabExportMapreq::class,'id', 'app_certi_lab_id')  ;
    }

    public function labCalRequests()
    {
        return $this->hasMany(LabCalRequest::class, 'app_certi_lab_id', 'id');
    }

    public function labTestRequests()
    {
        return $this->hasMany(LabTestRequest::class, 'app_certi_lab_id', 'id');
    }

    public function labRequestRejectTrackings()
    {
        return $this->hasMany(LabRequestRejectTracking::class, 'app_certi_lab_id', 'id');
    }

    public function allLabTestTransactionCategories()
    {
        // $categories = [];

        // foreach ($this->labTestRequests as $labTestRequest) {
        //     foreach ($labTestRequest->labTestTransactions as $labTestTransaction) {
        //         $categories[] = $labTestTransaction->category_th;
        //     }
        // }
        // return implode(', ', array_unique($categories));

              $categories = [];
       $certifyLabTests = CertifyTestScope::where('app_certi_lab_id',$this->id)->get();

       
      
        foreach ($certifyLabTests as $certifyLabTest) {
           
            if($certifyLabTest->Tablebranch != null){
                $categories[] = $certifyLabTest->Tablebranch->title;
            }
            
        }
        //  dd(implode(', ', array_unique($categories)));
        return implode(', ', array_unique($categories));
    }

    public function allLabCalTransactionCategories()
    {

        $categories = [];
       $certifyLabCalibrates = CertifyLabCalibrate::where('app_certi_lab_id',$this->id)->get();
        foreach ($certifyLabCalibrates as $certifyLabCalibrate) {
            if($certifyLabCalibrate->TableCalibrationBranch != null){
                $categories[] = $certifyLabCalibrate->TableCalibrationBranch->title;
            }
            
        }
        return implode(', ', array_unique($categories));
    }

    public function allCategories()
    {
        $categories = [];
       $certifyLabCalibrates = CertifyLabCalibrate::where('app_certi_lab_id',$this->id)->get();
    //   dd();
        foreach ($certifyLabCalibrates as $certifyLabCalibrate) {
            if($certifyLabCalibrate->TableCalibrationBranch != null){
                $categories[] = $certifyLabCalibrate->TableCalibrationBranch->title;
            }
            
        }
        return implode(', ', array_unique($categories));
    }

    public function FormulaTo()
    {
        return $this->belongsTo(Formula::class,'standard_id');
    }

}
