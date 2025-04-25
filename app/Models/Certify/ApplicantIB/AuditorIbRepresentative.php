<?php

namespace App\Models\Certify\ApplicantIB;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class AuditorIbRepresentative extends Model
{
    use Sortable;
    protected $table = 'auditor_ib_representatives';
    protected $primaryKey = 'id';
    protected $fillable = ['assessment_id','name','position'];

    public function certiIBSaveAssessment()
    {
        return $this->belongsTo(CertiIBSaveAssessment::class,'assessment_id');
    }
      
}
