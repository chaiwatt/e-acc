<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class AssessmentLabSchedule extends Model
{
    protected $table = "assessment_lab_schedules";
    protected $fillable = [
        'app_certi_lab_id', 
        'assessment_date',
        'assessment_time',
        'details',
        'assessment_ids'
        
    ];
}
