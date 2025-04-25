<?php

namespace App\Models\Certify\ApplicantCB;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class AuditorRepresentative extends Model
{
    use Sortable;
    protected $table = 'auditor_representatives';
    protected $primaryKey = 'id';
    protected $fillable = ['assessment_id','name','position'];

    public function certiCBSaveAssessment()
    {
        return $this->belongsTo(CertiCBSaveAssessment::class,'assessment_id');
    }
      
                            
}
