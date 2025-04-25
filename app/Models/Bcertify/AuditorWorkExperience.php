<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AuditorWorkExperience extends Model
{
    use Sortable;
    protected $fillable = [
        'auditor_id',
        'year',
        'position',
        'department',
        'role',
        'token',
    ];



    public function auditor(){
        return $this->belongsTo(AuditorInformation::class, 'auditor_id');
    }
}
