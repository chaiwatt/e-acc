<?php

namespace App\Models\Bcertify;

use App\Models\Basic\Amphur;
use App\Models\Basic\District;
use App\Models\Basic\Province;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\CertiLab;

class BranchLabAdress extends Model
{
    use Sortable;
    protected $fillable = [
        'app_certi_lab_id',
        'addr_no',
        'addr_moo',
        'addr_soi',
        'addr_road',
        'addr_moo_en',
        'addr_soi_en',
        'addr_road_en',
        'addr_province_id',
        'addr_amphur_id',
        'addr_tambol_id',
        'postal'
    ];
    protected $table = 'branch_lab_adresses';
    protected $primaryKey = 'id';

    public function certiLab()
    {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'addr_province_id', 'PROVINCE_ID');
    }

    public function amphur()
    {
        return $this->belongsTo(Amphur::class, 'addr_amphur_id', 'AMPHUR_ID');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'addr_tambol_id', 'DISTRICT_ID');
    }
}

