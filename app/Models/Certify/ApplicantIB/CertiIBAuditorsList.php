<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;
use App\Models\Bcertify\StatusAuditor;
class CertiIBAuditorsList  extends Model
{
    protected $table = 'app_certi_ib_auditors_list';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'auditors_id',
                            'status',
                            'auditors_status_id',
                            'user_id',
                            'temp_users',
                            'temp_departments'
                          ]; 

     public function CertiIBAuditorsStatusTo()
      {
        return $this->belongsTo(CertiIBAuditorsStatus::class,'auditors_status_id');
      }  
      
   public function StatusAuditorTo()
   {
     return $this->belongsTo(StatusAuditor::class,'status');
   }
   
   public function getStatusAuditorTitleAttribute() { 
    
     return @$this->StatusAuditorTo->title ?? '-';
   }     
}
