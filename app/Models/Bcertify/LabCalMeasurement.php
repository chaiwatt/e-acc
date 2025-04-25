<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\LabCalTransaction;
use App\Models\Bcertify\LabCalMeasurementRange;

class LabCalMeasurement extends Model
{
    use Sortable;
    protected $table = 'lab_cal_measurements';
    protected $primaryKey = 'id';

    protected $fillable = [
        'lab_cal_transaction_id', 'name', 'type'
    ];

    public function labCalTransaction()
    {
        return $this->belongsTo(LabCalTransaction::class, 'lab_cal_transaction_id', 'id');
    }

    public function labCalMeasurementRanges()
    {
        return $this->hasMany(LabCalMeasurementRange::class, 'lab_cal_measurement_id', 'id');
    }
}
