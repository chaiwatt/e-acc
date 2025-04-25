<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use HP;
use DB;

use App\User; 

use  App\Models\Esurv\Trader;

class CertiIBPayInOne extends Model
{
    use Sortable;

    protected $table = "app_certi_ib_pay_in1";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id',
                            'auditors_id',
                            'amount',
                            'start_date',
                            'status',
                             'state',  
                             'remark', 
                             'created_by',
                             'updated_by'
                            ];
  public function CertiIBAuditorsTo()
  {
      return $this->belongsTo(CertiIBAuditors::class,'auditors_id');
  }
  public function CertiIbTo()
  {
      return $this->belongsTo(CertiIb::class,'app_certi_ib_id');
  }
//   หลักฐานการชำระเงิน 
   public function FileAttachPayInOne1To()
  {
     $tb = new CertiIBPayInOne;
     return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',1)
                    ->orderby('id','desc');
  }
  // หลักฐานการชำระเงิน
  public function FileAttachPayInOne2To()
  {
     $tb = new CertiIBPayInOne;
     return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',2)
                    ->orderby('id','desc');
  }
}