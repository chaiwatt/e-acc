<?php

namespace App\Models\Certify\ApplicantCB;

use DB;
use HP;

use App\User; 
use  App\Models\Esurv\Trader;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\AuditorRepresentative;

class CertiCBSaveAssessment extends Model
{
    use Sortable;
    protected $table = 'app_certi_cb_assessment';
    protected $primaryKey = 'id';
    // protected $fillable = ['app_certi_cb_id','auditors_id','name','laboratory_name','report_date','details','bug_report','degree','created_by', 'updated_by','submit_type','expert_token','accept_fault','notice_duration','notice_confirm_date'];
    protected $fillable = ['app_certi_cb_id','auditors_id', 'name','laboratory_name','report_date','bug_report','degree','main_state','details','date_car','status_car','state','created_by', 'updated_by'
    ,'date_scope_edit','submit_type','expert_token','accept_fault','notice_duration','notice_confirm_date'];
   
    public function getDegreeTitleAttribute() {
        $degree = ['0'=>'ฉบับร่าง','1'=>'พบข้อบกพร่อง','2'=>'พบข้อบกพร่อง','3'=>'ไม่ผ่าน','4'=>'ผ่าน'];
        if( array_key_exists($this->degree,$degree)){
            return $degree[$this->degree];
        }else{
            return "เกิดข้อผิดพลาด";
        }
  
      }
    
    public function UserTo()
    {
        return $this->belongsTo(User::class,'created_by','runrecno');
    }
    public function CertiCBCostTo()
    {
        return $this->belongsTo(CertiCb::class,'app_certi_cb_id');
    }
           // แต่งตั้งคณะผู้ตรวจประเมิน
   public function CertiCBAuditorsTo()
   {
       return $this->belongsTo(CertiCBAuditors::class,'auditors_id','id') ;
   } 
    public function CertiCBBugMany()
    {
       return $this->hasMany(CertiCBSaveAssessmentBug::class, 'assessment_id','id');
    }
    public function auditorRepresentatives()
    {
       return $this->hasMany(AuditorRepresentative::class, 'assessment_id','id');
    }
    
    public function CertiCBHistorys()
    {
      $tb = new CertiCBSaveAssessment;
    return $this->hasMany(CertiCbHistory::class, 'ref_id')
              ->where('table_name',$tb->getTable()) 
              ->where('system',7);
    }
    public function LogCertiCBHistorys()
    {
      $tb = new CertiCBSaveAssessment;
    return $this->hasMany(CertiCbHistory::class, 'ref_id')
              ->where('table_name',$tb->getTable()) 
              ->where('system',8);
    }
    //รายงานการตรวจประเมิน
    public function FileAttachAssessment1To()
    {
        $tb = new CertiCBSaveAssessment;
        return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',1)
                    ->orderby('id','desc');
    }
    //รายงาน Scope
    public function FileAttachAssessment2To()
    {
        $tb = new CertiCBSaveAssessment;
        return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',2)
                    ->orderby('id','desc');
    }
    //ไฟล์แนบ
    public function FileAttachAssessment3Many()
    {
       $tb = new CertiCBSaveAssessment;
       return $this->hasMany(CertiCBAttachAll::class, 'ref_id','id')
                   ->select('id','file')
                   ->where('table_name',$tb->getTable())
                   ->where('file_section',3);
    }

    
        //รายงาน Scope
        public function FileAttachAssessment4To()
        {
            $tb = new CertiCBSaveAssessment;
            return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                        ->where('table_name',$tb->getTable())
                        ->where('file_section',4)
                        ->orderby('id','desc');
        }
    //ไฟล์แนบ car
    public function FileAttachAssessment5To()
    {
       $tb = new CertiCBSaveAssessment;
        return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                       ->where('table_name',$tb->getTable())
                       ->where('file_section',5)
                       ->orderby('id','desc');
     }
      // ไม่เห็นชอบกับ Scope
      public function FileAttachAssessment6Many()
      {
         $tb = new CertiCBSaveAssessment;
          return $this->hasMany(CertiCBAttachAll::class,'ref_id','id')
                         ->where('table_name',$tb->getTable())
                         ->where('file_section',6)
                         ->orderby('id','desc');
       }
}
