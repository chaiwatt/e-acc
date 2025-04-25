<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;
use stdClass;
use App\Models\Bcertify\StatusAuditor;
use App\Models\Bcertify\AuditorExpertise;
class CertiIBAuditorsStatus  extends Model
{
    protected $table = 'app_certi_ib_auditors_status';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'auditors_id',
                            'status'
                          ];

   public function CertiIBAuditorsLists()
   {
    return $this->hasMany(CertiIBAuditorsList::class, 'auditors_status_id');
   }

   public function StatusAuditorTo()
   {
     return $this->belongsTo(StatusAuditor::class,'status');
   }
   
   public function getStatusAuditorTitleAttribute() { 
    
     return @$this->StatusAuditorTo->title ?? '-';
   }
   public function getAuditorExpertiseTitleAttribute() { 
    $Auditor =  AuditorExpertise::where('type_of_assessment',2) ->get(); 
    $Expertise =[];
     foreach($Auditor as $key => $item ) {
      $auditor_status =  explode(",",$item->auditor_status) ;
      if(in_array($this->status,$auditor_status)){
        $data = new stdClass;
        $data->id =  $item->auditor_id ?? '-';
        $data->NameTh =  $item->auditor->NameThTitle ?? '-';
        $data->department = !is_null($item->auditor->DepartmentTitle) ? $item->auditor->DepartmentTitle : '-' ;
        $data->position =  $item->auditor->position ?? '-';
        $data->branchable =  $item->InspectBranchTitle ?? '-';
        $Expertise[] = $data ;
      }
     } 
     return $Expertise;
   }
                          
}
