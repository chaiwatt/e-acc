<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\LabTestTransaction;

class LabTestMeasurement extends Model
{
    use Sortable;
    protected $table = 'lab_test_measurements';
    protected $primaryKey = 'id';

    protected $fillable = [
        'lab_test_transaction_id', 'name', 'type','name_eng','description','detail'
    ];

    public function labTestTransaction()
    {
        return $this->belongsTo(LabTestTransaction::class, 'lab_test_transaction_id', 'id');
    }

}

