<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CostAssessmentHistory extends Model
{
    protected $table = "cost_assessment_history";
    protected $fillable = ['assessments_id','amount','invoice','status_confirmed','file','report_date'];

}
