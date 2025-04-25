<?php

namespace App\Models\Certificate;
use HP;
use App\User; 
use App\AttachFile;
use App\CertificateExport;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;
use App\Models\Certify\MessageRecordTrackingTransaction;
use App\Models\Bcertify\BoardAuditorTrackingMsRecordInfo;

class  TrackingAuditors extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_auditors";
    protected $primaryKey = 'id';
    protected $fillable = ['tracking_id','certificate_type', 'reference_refno', 'ref_table', 'ref_id', 'no', 
    'auditor', 'vehicle', 'status', 'remark', 'step_id', 'status_cancel', 'reason_cancel', 'created_cancel', 'date_cancel', 'state', 'created_by', 'updated_by','message_record_status'];


    public function tracking_to()
    {
        return $this->belongsTo(Tracking::class,'tracking_id');
    }



    public function auditors_date_many()
    {
     return $this->hasMany(TrackingAuditorsDate::class, 'auditors_id','id' );
    }
 
   // start ประวัติคำขอรับใบรับรองห้องปฏิบัติการ
    public function history_labs_many(){
       return $this->hasMany(TrackingHistory::class, 'ref_id', 'ref_id')
                    ->where('ref_table',(new CertificateExport)->getTable() )
                    ->where('table_name',$this->table )
                    ->where('refid',$this->id )
                    ->where('reference_refno',$this->reference_refno )
                    ->where('certificate_type',3 ) 
                    ->where('system',4 );
     }
   // end ประวัติคำขอรับใบรับรองห้องปฏิบัติการ


     // start ประวัติคำขอรับใบรับรองหน่วยตรวจ
      public function history_ib_many(){
        return $this->hasMany(TrackingHistory::class, 'ref_id', 'ref_id')
                     ->where('ref_table',(new CertiIBExport)->getTable() )
                     ->where('table_name',$this->table )
                     ->where('refid',$this->id )
                     ->where('reference_refno',$this->reference_refno )
                     ->where('certificate_type',2) 
                     ->where('system',4 );
      }
    // end ประวัติคำขอรับใบรับรองหน่วยตรวจ

      // start ประวัติคำขอรับใบรับรองระบบงาน
      public function history_cb_many(){
        return $this->hasMany(TrackingHistory::class, 'ref_id', 'ref_id')
                     ->where('ref_table',(new CertiCBExport)->getTable() )
                     ->where('table_name',$this->table )
                     ->where('refid',$this->id )
                     ->where('reference_refno',$this->reference_refno )
                     ->where('certificate_type',1) 
                     ->where('system',4 );
      }
    // end ประวัติคำขอรับใบรับรองระบบงาน

   
    public function FileAuditors1()
    {
 
       return $this->belongsTo(AttachFile::class,'id','ref_id')
                   ->select('id','new_filename','filename','url')
                   ->where('ref_table',$this->table)
                   ->where('section','other_attach');
    }  
    public function FileAuditors2()
    {
 
       return $this->belongsTo(AttachFile::class,'id','ref_id')
                   ->select('id','new_filename','filename','url')
                   ->where('ref_table',$this->table)
                   ->where('section','attach');
    }    
    public function getCertiAuditorsDateTitleAttribute() {
      $data = HP::getArrayFormSecondLevel($this->auditors_date_many->toArray(), 'id');
      $datas = TrackingAuditorsDate::select('start_date','end_date')->whereIn('id', $data)->get();
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

    public function messageRecordTrackingTransactions()
    {
        return $this->hasMany(MessageRecordTrackingTransaction::class, 'ba_tracking_id', 'id');
    }

    public function boardAuditorTrackingMsRecordInfos()
    {
        return $this->hasMany(BoardAuditorTrackingMsRecordInfo::class, 'tracking_auditor_id', 'id');
    }


}
