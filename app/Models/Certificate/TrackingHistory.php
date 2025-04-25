<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use App\CertificateExport;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;


class TrackingHistory extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_history";
    protected $primaryKey = 'id';
    protected $fillable = ['tracking_id','certificate_type', 'reference_refno', 'ref_table', 'ref_id', 'system', 'details_one', 'details_two', 'details_three', 'details_four',
                              'details_five', 'details_auditors_cancel', 'file', 'attachs', 'attachs_car', 'status', 'status_scope', 'remark', 'attachs_file', 'evidence', 'date', 
                               'user_id', 'created_by', 'updated_by','auditors_id','table_name','refid'
                       ];


/*
    User Relation
*/
    public function user_created(){
    return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
    return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCreatedNameAttribute() {
        return @$this->user_created->reg_fname.' '.@$this->user_created->reg_lname;
    }

    public function getUpdatedNameAttribute() {
        return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
    }   

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
    
    public function getDataSystemAttribute() {
        $details = ['1'=>'รอดำเนินการ',
                    '2'=>'มอบหมายการตรวจติดตาม',
                    '3'=>'อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน',
                    '4'=>'แต่งคณะผู้ตรวจประเมิน' ,
                    '5'=>'Pay-In ครั้งที่ 1' ,
                    '6'=> 'ข้อบกพร่อง/ข้อสังเกต',
                    '7'=> 'บันทึกผลการตรวจประเมิน',
                    '8'=> 'สรุปผลตรวจประเมิน',
                    '9'=> 'สรุปรายงาน',
                    '10'=> 'ทบทวนฯ',
                    '11'=> 'Pay-In ครั้งที่ 2'
                  ];
        return  array_key_exists($this->system,$details) ?  $details[$this->system] : '-';
    }


    // start ประวัติคำขอรับใบรับรองห้องปฏิบัติการ
    public function history_labs_many(){
        return $this->hasMany(TrackingHistory::class, 'ref_id', 'ref_id')->where('ref_table',(new CertificateExport)->getTable() )->where('reference_refno',$this->reference_refno )->where('certificate_type',3 )->orderBy('id', 'desc');
      }
        // end ประวัติคำขอรับใบรับรองห้องปฏิบัติการ
       
    // start ประวัติคำขอรับใบรับรองหน่วยตรวจ
    public function history_ib_many(){
        return $this->hasMany(TrackingHistory::class, 'ref_id', 'ref_id')->where('ref_table',(new CertiIBExport)->getTable() )->where('reference_refno',$this->reference_refno )->where('certificate_type',2)->orderBy('id', 'desc');
      }
    // end ประวัติคำขอรับใบรับรองหน่วยตรวจ 


   // start ประวัติคำขอรับใบรับรองหน่วยรับรอง
    public function history_cb_many(){
        return $this->hasMany(TrackingHistory::class, 'ref_id', 'ref_id')->where('ref_table',(new CertiCBExport)->getTable() )->where('reference_refno',$this->reference_refno )->where('certificate_type',1)->orderBy('id', 'desc');
      }
    // end ประวัติคำขอรับใบรับรองหน่วยรับรอง

      
        public function getDataBoardAuditorDateTitleAttribute() {
            $details =   json_decode($this->details_two);
            $datas = [];
            $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            if(count($details) > 0) {
               foreach($details  as $key => $list){
                if(!is_null($list->start_date) &&!is_null($list->end_date)){
                //     // ปี
                    $StartYear = date("Y", strtotime($list->start_date)) +543;
                    $EndYear = date("Y", strtotime($list->end_date)) +543;
                   // เดือน
                   $StartMonth= date("n", strtotime($list->start_date));
                   $EndMonth= date("n", strtotime($list->end_date));
                //    //วัน
                   $StartDay= date("j", strtotime($list->start_date));
                   $EndDay= date("j", strtotime($list->end_date));
                   if($StartYear == $EndYear){  // ปีเท่ากับ
                       if($StartMonth == $EndMonth){ // เดือนเท่ากับ
                             if($StartDay == $EndDay){ //  วันเท่ากับ
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
            }
            return implode("<br>",$datas);
          }
        



}
