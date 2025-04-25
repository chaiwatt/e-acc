<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabMaterialLef extends Model
{
    protected $table = 'app_certi_lab_material_lef';

    protected $fillable = [
      'app_certi_lab_id',
        'no',
        'name',
        'ref_value',
        'manufacturer',
        'batch_no',
        'testing',
        'cali_anni_date',
        'certi_material_file',
        'token'
    ];

    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }
}
