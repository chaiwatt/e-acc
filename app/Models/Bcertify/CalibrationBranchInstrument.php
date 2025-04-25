<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;

class CalibrationBranchInstrument extends Model
{
    use Sortable;
    protected $fillable = [
        'calibration_branch_instrument_group_id',
        'name',
        'state'
    ];
    protected $table = 'calibration_branch_instruments';
    protected $primaryKey = 'id';

    public function calibrationBranchInstrumentGroup()
    {
        return $this->belongsTo(CalibrationBranchInstrumentGroup::class, 'calibration_branch_instrument_group_id', 'id');
    }
}
