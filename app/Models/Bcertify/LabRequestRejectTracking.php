<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\CertiLab;

class LabRequestRejectTracking extends Model
{
    use Sortable;
    protected $table = 'lab_request_reject_trackings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_id', 
        'date'
    ];
    public function certiLab()
    {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id', 'id');
    }
}

