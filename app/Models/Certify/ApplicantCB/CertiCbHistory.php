<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use HP;


class CertiCbHistory extends Model
{
    use Sortable;

    protected $table = "app_certi_cb_history";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id',
                            'system',
                            'table_name',
                            'ref_id',
                            'details_one',
                            'details_two',
                            'details_three',
                            'details_four',
                             'file',
                             'attachs',
                             'status',
                             'attachs_file',
                             'status_scope',
                             'remark',
                             'evidence',
                             'date',
                             'created_by',
                             'updated_by',                       
                            ]; 
   
   public function user_created(){
    return $this->belongsTo(User::class, 'created_by','runrecno');
   }
    public function getMaxAmountDateAttribute() {
            $details =   json_decode($this->details_two);
            $count_date = [];
            if(count($details) > 0) {
            foreach($details  as $item){
                $amount_date = !empty($item->amount_date) ? $item->amount_date : 0 ;
                $count_date[] = $amount_date;

            }
            }
            return  max($count_date) ?? '-';
    }

    public function getSumAmountAttribute() {
        $details =   json_decode($this->details_two);
        $countItem = 0;
        if(count($details) > 0) {
            foreach($details  as $item){
                $amount_date = !empty($item->amount_date) ? $item->amount_date : 0 ;
                $amount = !empty($item->amount) ? $item->amount : 0 ;
                $countItem += ($amount*$amount_date);
            }
        }
        return  number_format($countItem,2) ?? '-';
    }

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

      public function getDataSystemAttribute() {
        $details = ['1'=>'ขอเอกสารเพิ่มเติม',
                    '2'=>'ยกเลิกคำขอ',
                    '3'=>'ไม่ผ่านการตรวจสอบ', 
                    '4'=>'การประมาณค่าใช้จ่าย', 
                    '5'=> 'แต่งตั้งคณะผู้ตรวจประเมิน',
                    '6'=> 'Pat-In ครั้งที่ 1',
                    '7'=> 'ข้อบกพร่อง/ข้อสังเกต',
                    '8'=> 'บันทึกผลการตรวจประเมิน',
                    '9'=> 'สรุปรายงานและเสนอกรรมการฯ',
                    '10'=> 'Pay-in ครั้งที่ 2',
                    '11'=> 'ทบทวนฯ'
                  ];
        return  array_key_exists($this->system,$details) ?  $details[$this->system] : '-';
    }
}