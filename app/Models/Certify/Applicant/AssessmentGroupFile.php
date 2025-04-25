<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class AssessmentGroupFile extends Model
{
    protected $table = "app_certi_lab_assessment_group_files";

    public function assessment_group() {
        return $this->belongsTo(AssessmentGroup::class, 'app_certi_assessment_group_id');
    }
}
