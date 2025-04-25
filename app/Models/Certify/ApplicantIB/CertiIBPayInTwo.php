<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use HP;
use DB;

use App\User; 

use  App\Models\Esurv\Trader;

class CertiIBPayInTwo extends Model
{
    use Sortable;

    protected $table = "app_certi_ib_pay_in2";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id',
                            'amount',
                            'amount_fee',
                            'report_date',
                             'detail',
                             'status',  
                             'degree', 
                             'created_by',
                             'updated_by'
                            ];

  public function FileAttachPayInTwo1To()
  {
     $tb = new CertiIBPayInTwo;
     return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',1)
                    ->orderby('id','desc');
  }
  public function FileAttachPayInTwo2To()
  {
     $tb = new CertiIBPayInTwo;
     return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',2)
                    ->orderby('id','desc');
  }
  public function FileAttachPayInTwo3To()
  {
     $tb = new CertiIBPayInTwo;
     return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',3)
                    ->orderby('id','desc');
  }
  public function FileAttachPayInTwo4To()
  {
     $tb = new CertiIBPayInTwo;
     return $this->belongsTo(CertiIBAttachAll::class, 'id','ref_id')
                    ->where('table_name',$tb->getTable())
                    ->where('file_section',4)
                    ->orderby('id','desc');
  }
}