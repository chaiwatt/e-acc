<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Bcertify\StatusAuditor;
use App\Models\Bcertify\AuditorExpertise;


class  TrackingAuditorsStatus extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_auditors_status";
    protected $primaryKey = 'id';
    protected $fillable = ['auditors_id', 'status_id', 'amount', 'amount_date' ];


    public function auditors_list_many()
    {
     return $this->hasMany(TrackingAuditorsList::class, 'auditors_status_id' );
    }
 
    public function status_auditor_to()
    {
      return $this->belongsTo(StatusAuditor::class,'status_id');
    }
    
    public function getStatusAuditorTitleAttribute() { 
     
      return @$this->status_auditor_to->title ?? '-';
    }
    public function getAuditorExpertiseTitleAttribute() { 
     $Auditor =  AuditorExpertise::where('type_of_assessment',2) ->get(); 
     $Expertise =[];
      foreach($Auditor as $key => $item ) {
       $auditor_status =  explode(",",$item->auditor_status) ;
       if(in_array($this->status_id,$auditor_status)){
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
