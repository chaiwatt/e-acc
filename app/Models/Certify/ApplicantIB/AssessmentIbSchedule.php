<?php

namespace App\Models\Certify\ApplicantIb;

use Illuminate\Database\Eloquent\Model;

class AssessmentIbSchedule extends Model
{
    protected $table = "assessment_ib_schedules";
    protected $fillable = [
        'app_certi_ib_id', 
        'assessment_date',
        'assessment_time',
        'details',
        'assessment_ids'
        
    ];
}
