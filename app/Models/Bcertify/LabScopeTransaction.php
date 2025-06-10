<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\CertiLab;

class LabScopeTransaction extends Model
{
    use Sortable;
    protected $table = 'lab_scope_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_id',
        'branch_id',
        'request_type',
        'lab_type',
        'checkbox_main',
        'address_number',
        'village_no',
        'address_soi',
        'address_street',
        'address_district',
        'address_city',
        'address_city_text',
        'sub_district',
        'postcode',
        'labress_no_eng',
        'lab_moo_eng',
        'lab_soi_eng',
        'lab_street_eng',
        'lab_district_eng',
        'lab_amphur_eng',
        'lab_province_eng',
        'lab_province_text_eng',
        'lab_types',
    ];

    protected $casts = [
        'lab_types' => 'array', // แปลง lab_types เป็น array อัตโนมัติเมื่อ query
    ];

    public function certiLab()
    {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id', 'id');
    }
}
