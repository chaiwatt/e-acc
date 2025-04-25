<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PayInAll extends Model
{
    use Sortable;
    protected $table = "app_certi_pay_in_all";
    protected $primaryKey = 'id';
    protected $fillable = ['ref_id', 'ref_table','conditional_type','amount','start_date','app_no', 'name','tax_id','name_unit','auditors_name','certify','detail',  'state','created_by','updated_by' ,'start_date_feewaiver','end_date_feewaiver','attach'
                            ];
 
   public function getConditionalTypeNameAttribute() {
        $type   = ['1'=>'เรียกเก็บค่าธรรมเนียม','2'=>'ยกเว้นค่าธรรมเนียม','3'=>' ชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆ'];
        return array_key_exists($this->conditional_type,$type) ? $type[$this->conditional_type] : '-';
    }
}
