<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AuditorTraining extends Model
{
    use Sortable;
    protected $fillable = [
        'auditor_id',
        'course_name',
        'department_name',
        'start_training',
        'end_training',
        'token',
    ];


    public function auditor(){
        return $this->belongsTo(AuditorInformation::class, 'auditor_id');
    }
}
