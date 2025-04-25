<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use App\Models\Bcertify\LabTestRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\LabTestMeasurement;

class LabTestTransaction extends Model
{
    use Sortable;
    protected $table = 'lab_test_transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'lab_test_request_id','key', 'index', 'category',
        'category_th','description',
        'standard', 'code','test_field','test_field_eng'
    ];

    public function labTestRequest()
    {
        return $this->belongsTo(LabTestRequest::class, 'lab_test_request_id', 'id');
    }

    public function labTestMeasurements()
    {
        return $this->hasMany(LabTestMeasurement::class, 'lab_test_transaction_id', 'id');
    }
}
