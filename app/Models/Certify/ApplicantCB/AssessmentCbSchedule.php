<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class AssessmentCbSchedule extends Model
{
    protected $table = "assessment_cb_schedules";
    protected $fillable = [
        'app_certi_cb_id', 
        'assessment_date',
        'assessment_time',
        'details',
        'assessment_ids'
        
    ];
}
