<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiToolsCalibrate extends Model
{
    protected $table = 'app_certi_tools_calibrates';

    protected $fillable = [
      'app_certi_lab_id',
        'name',
        'type',
        'code_no',
        'capability',
        'usage_time',
        'standard',
        'cali_times',
        'cali_latest_date',
        'cali_depart',
        'token'
    ];

    public function getRouteKeyName()
    {
        return 'token';
    }
}
