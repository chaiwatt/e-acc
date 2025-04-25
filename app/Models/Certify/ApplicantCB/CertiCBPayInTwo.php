<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use HP;
use DB;

use App\User; 

use  App\Models\Esurv\Trader;

class CertiCBPayInTwo extends Model
{
    use Sortable;

    protected $table = "app_certi_cb_pay_in2";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id',
                            'amount',
                            'amount_fee',
                            'report_date',
                             'detail', 
                             'status', 
                             'degree', 
                             'created_by',
                             'updated_by'
                            ];
   // ค่าธรรมเนียมคำขอ                        
  public function FileAttachPayInTwo1To()
  {
     $tb = new CertiCBPayInTwo;
     return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',1)
                    ->orderby('id','desc');
  }
  //  ค่าธรรมเนียมใบรับรอง
  public function FileAttachPayInTwo2To()
  {
     $tb = new CertiCBPayInTwo;
     return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',2)
                    ->orderby('id','desc');
  }
  //หลักฐานค่าธรรมเนียมใบคำขอ
  public function FileAttachPayInTwo3To()
  {
     $tb = new CertiCBPayInTwo;
     return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',3)
                    ->orderby('id','desc');
  }
  //หลักฐานค่าธรรมเนียมใบรับรอง
  public function FileAttachPayInTwo4To()
  {
     $tb = new CertiCBPayInTwo;
     return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',4)
                    ->orderby('id','desc');
  }
}