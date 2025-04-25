<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class AssessmentGroup extends Model
{
    protected $table = "app_certi_lab_assessment_groups";
    protected $fillable = ['app_certi_assessment_id','app_certi_lab_id','sequence',
    'checker_id','status','remark','assessment_date','comment_date','status_confirmed'];
    protected $dates = [
        'assessment_date',
        'comment_date'
    ];

    public function assessment() {
        return $this->belongsTo(Assessment::class, 'app_certi_assessment_id');
    }

    public function applicant() {
        return $this->belongsTo('App\User', 'app_certi_lab_id');
    }

    public function checker() {
        return $this->belongsTo('App\User', 'checker_id');
    }

    public function files() {
        return $this->hasMany(AssessmentGroupFile::class, 'app_certi_assessment_group_id');
    }

    public function auditors() {
        return $this->hasMany(AssessmentGroupAuditor::class, 'app_certi_assessment_group_id');
    }
}
