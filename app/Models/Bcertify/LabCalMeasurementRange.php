<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\LabCalMeasurement;

class LabCalMeasurementRange extends Model
{
    use Sortable;
    protected $table = 'lab_cal_measurement_ranges';
    protected $primaryKey = 'id';

    protected $fillable = [
        'lab_cal_measurement_id', 'description', 'range','uncertainty'
    ];

    public function labCalMeasurement()
    {
        return $this->belongsTo(LabCalMeasurement::class, 'lab_cal_measurement_id', 'id');
    }
}
