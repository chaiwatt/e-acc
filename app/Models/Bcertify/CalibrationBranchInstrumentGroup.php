<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Bcertify\CalibrationBranchParam1;
use App\Models\Bcertify\CalibrationBranchParam2;
use App\Models\Bcertify\CalibrationBranchInstrument;

class CalibrationBranchInstrumentGroup extends Model
{
    use Sortable;
    protected $fillable = [
        'bcertify_calibration_branche_id',
        'name',
        'state',
    ];

    protected $table = 'calibration_branch_instrument_groups';
    protected $primaryKey = 'id';

    public function calibrationBranch()
    {
        return $this->belongsTo(CalibrationBranch::class, 'bcertify_calibration_branche_id', 'id');
    }

    public function calibrationBranchInstruments()
    {
        return $this->hasMany(CalibrationBranchInstrument::class, 'calibration_branch_instrument_group_id', 'id');
    }
    public function calibrationBranchParam1s()
    {
        return $this->hasMany(CalibrationBranchParam1::class, 'calibration_branch_instrument_group_id', 'id');
    }
    public function calibrationBranchParam2s()
    {
        return $this->hasMany(CalibrationBranchParam2::class, 'calibration_branch_instrument_group_id', 'id');
    }
}
