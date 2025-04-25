<?php
namespace App\Models\Certify;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use HP;
use App\Models\Certify\BoardAuditorDate;


class BoardAuditorHistory extends Model
{

    protected $table = "board_auditors_history";
    protected $primaryKey = 'id';
    protected $fillable = ['board_auditor_id', 'no', 'details_date', 'file','attach','groups','status','remark','attach_files','date'];


    public function getDataBoardAuditorDateTitleAttribute() {
        $details =   json_decode($this->details_date);
        $datas = [];
        $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        if(count($details) > 0) {
           foreach($details  as $key => $list){
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
