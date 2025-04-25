<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabPlace extends Model
{
    //
    protected $table = "app_certi_lab_place";
    protected $fillable = [
                            'app_certi_lab_id',
                            'permanent_operating_site',
                            'off_site_operations',
                            'temporary_operating_site',
                            'mobile_operating_facility',
                            'multi_site_facility',
                            'token'
                            ];
    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }
}
