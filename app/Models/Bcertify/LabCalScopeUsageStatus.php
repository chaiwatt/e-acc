<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Bcertify\LabCalScopeTransaction;

class LabCalScopeUsageStatus extends Model
{
    use Sortable;
    protected $table = 'lab_cal_scope_usage_statuses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_id', 
        'group', 
        'status'
    ];
    public function certiLab()
    {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id', 'id');
    }
    public function transactions()
    {
        return $this->hasMany(LabCalScopeTransaction::class, 'app_certi_lab_id', 'app_certi_lab_id')
                    ->where('group', $this->group);
    }
}
