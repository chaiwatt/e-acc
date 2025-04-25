<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use App\User;
class AssessmentExaminer extends Model
{
    protected $table = "app_certi_lab_assessments_examiner";
    protected $fillable = [
        'app_certi_lab_assessments_id', 'user_id','app_certi_lab_id'
        
    ];

    public function assessments() {
        return $this->belongsTo(Assessment::class, 'app_certi_lab_assessments_id');
    }
    public function CertiLabs() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }
    
    public function checker() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
