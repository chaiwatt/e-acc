<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
class CertiIBCost  extends Model
{
    protected $table = 'app_certi_ib_costs';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id', 'draft', 'check_status', 'remark', 'vehicle',
                            'status_scope', 'remark_scope', 'created_by', 'updated_by','date'
                          ];

 public function CertiIBCostTo()
 {
     return $this->belongsTo(CertiIb::class,'app_certi_ib_id');
 }
   
 public function UserTo()
 {
     return $this->belongsTo(User::class,'created_by','runrecno');
 }
 public function items() {
  return $this->hasMany(CertiIBCostItem::class, 'app_certi_cost_id');
}
   
public function CertiIbHistorys()
{
    $tb = new CertiIBCost;
    return $this->hasMany(CertiIbHistory::class, 'ref_id')
              ->where('table_name',$tb->getTable()) 
              ->where('system',4);
}

  public function FileAttachCost1()
  {
     $tb = new CertiIBCost;
     return $this->hasMany(CertiIBAttachAll::class, 'ref_id','id')
                 ->select('id','file')
                 ->where('table_name',$tb->getTable())
                 ->where('file_section',1);
  }
                         
}
