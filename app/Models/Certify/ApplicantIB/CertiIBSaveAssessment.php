<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use HP;
use DB;

use App\User; 

use  App\Models\Esurv\Trader;

class CertiIBSaveAssessment extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_certi_ib_assessment';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['app_certi_ib_id','auditors_id', 'name','laboratory_name','report_date','bug_report','status','degree','details','created_by', 'updated_by','date_scope_edit','submit_type','expert_token','accept_fault','notice_duration','notice_confirm_date'];
   
 
    public function UserTo()
    {
        return $this->belongsTo(User::class,'created_by','runrecno');
    }
    public function CertiIBCostTo()
    {
        return $this->belongsTo(CertiIb::class,'app_certi_ib_id');
    }

    public function CertiIBBugMany()
    {
       return $this->hasMany(CertiIBSaveAssessmentBug::class, 'assessment_id','id');
    }
   // แต่งตั้งคณะผู้ตรวจประเมิน
   public function CertiIBAuditorsTo()
   {
       return $this->belongsTo(CertiIBAuditors::class,'auditors_id','id') ;
   } 
    //รายงานการตรวจประเมิน
    public function FileAttachAssessment1To()
    {
        $tb = new CertiIBSaveAssessment;
        return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',1)
                    ->orderby('id','desc');
    }
    //รายงาน Scope
    public function FileAttachAssessment2Many()
    {
        $tb = new CertiIBSaveAssessment;
        return $this->hasMany(CertiIBAttachAll::class, 'ref_id','id')
                    ->select('id','file')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',2)
                    ->orderby('id','desc');
    }
    //สรุปรายงานการตรวจทุกครั้ง
    public function FileAttachAssessment3Many()
    {
       $tb = new CertiIBSaveAssessment;
       return $this->hasMany(CertiIBAttachAll::class, 'ref_id','id')
                   ->select('id','file')
                   ->where('table_name',$tb->getTable())
                   ->where('file_section',3);
    }
    //ไฟล์แนบ
    public function FileAttachAssessment4Many()
    {
       $tb = new CertiIBSaveAssessment;
       return $this->hasMany(CertiIBAttachAll::class, 'ref_id','id')
                   ->select('id','file')
                   ->where('table_name',$tb->getTable())
                   ->where('file_section',4);
    }
    //ไฟล์แนบ car
     public function FileAttachAssessment5To()
     {
        $tb = new CertiIBSaveAssessment;
         return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                        ->where('table_name',$tb->getTable())
                        ->where('file_section',5)
                        ->orderby('id','desc');
      }
      // ไม่เห็นชอบกับ Scope
      public function FileAttachAssessment6Many()
      {
         $tb = new CertiIBSaveAssessment;
          return $this->hasMany(CertiIBAttachAll::class,'ref_id','id')
                         ->where('table_name',$tb->getTable())
                         ->where('file_section',6)
                         ->orderby('id','desc');
       }
 


    public function CertiIbHistorys()
    {
      $tb = new CertiIBSaveAssessment;
    return $this->hasMany(CertiIbHistory::class, 'ref_id')
              ->where('table_name',$tb->getTable()) 
              ->where('system',7);
    }
   public function LogCertiIbHistorys()
   {
    $tb = new CertiIBSaveAssessment;
    return $this->hasMany(CertiIbHistory::class, 'ref_id','id')
              ->where('table_name',$tb->getTable()) 
              ->where('system',8);
   }

}
