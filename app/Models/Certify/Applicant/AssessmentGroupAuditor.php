<?php

namespace App\Models\Certify\Applicant;

use App\Models\Certify\BoardAuditor;
use Illuminate\Database\Eloquent\Model;

class AssessmentGroupAuditor extends Model
{
    protected $table = "app_certi_lab_assessment_group_auditors";
    protected $fillable = ['app_certi_assessment_group_id','app_certi_lab_id','auditor_id',
    'created_by','updated_by'];
    public function assessment_group() {
        return $this->belongsTo(AssessmentGroup::class, 'app_certi_assessment_group_id');
    }

    public function auditor() {
        return $this->belongsTo(BoardAuditor::class, 'auditor_id');
    }
}
