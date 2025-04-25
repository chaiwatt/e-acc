<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\LabCalTransaction;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Bcertify\LabTestTransaction;

class LabTestRequest extends Model
{
    use Sortable;
    protected $table = 'lab_test_requests';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_id', 
        'type',
        'no',
        'moo',
        'soi',
        'street',
        'province_id',
        'province_name',
        'amphur_id',
        'amphur_name',
        'tambol_id',
        'tambol_name',
        'postal_code',
        'no_eng',
        'moo_eng',
        'soi_eng',
        'street_eng',
        'tambol_name_eng',
        'amphur_name_eng',
        'province_name_eng'
    ];
    
    public function certiLab()
    {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id', 'id');
    }

    public function labTestTransactions()
    {
        return $this->hasMany(LabTestTransaction::class, 'lab_test_request_id', 'id');
    }
}
