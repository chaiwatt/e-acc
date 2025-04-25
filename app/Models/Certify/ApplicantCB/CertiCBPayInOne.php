<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use HP;
use DB;

use App\User; 

use  App\Models\Esurv\Trader;

class CertiCBPayInOne extends Model
{
    use Sortable;

    protected $table = "app_certi_cb_pay_in1";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id',
                            'amount',
                            'start_date',
                            'auditors_id',
                            'status',
                             'state',  
                             'remark', 
                             'created_by',
                             'updated_by'
                            ];
   public function CertiCbCostTo()
   {
     return $this->belongsTo(CertiCb::class,'app_certi_cb_id');
   }                         
  public function CertiCBAuditorsTo()
  {
      return $this->belongsTo(CertiCBAuditors::class,'auditors_id');
  }
    // หลักฐานการชำระ จนท.
   public function FileAttachPayInOne1To()
  {
     $tb = new CertiCBPayInOne;
     return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',1)
                    ->orderby('id','desc');
  }
    // หลักฐานการชำระ ผปก.
  public function FileAttachPayInOne2To()
  {
     $tb = new CertiCBPayInOne;
     return $this->belongsTo(CertiCBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',2)
                    ->orderby('id','desc');
  }
}